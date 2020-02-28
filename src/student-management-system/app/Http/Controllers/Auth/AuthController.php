<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Validators\RoleValidator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;
use Validator;

/**
 * @group Authentication
 *
 * APIs for managing user
 */
class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => 'required|exists:users',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $credentials = request(['login_id', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid password'
            ], 401);
        }
//
//

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
//        if ($request->remember_me)
        //TODO: expire token immediately and see what happens on access requests and how to get new token
//            $token->expires_at = Carbon::now()->addWeeks(1);

        //TODO: Observed that every time I login a new token is generated, older one still being valid!,
        // should you expire older tokens? If yes, that means a user will be able to login from only one location
        // Consider short lived access tokens, pass a refresh token in login.
        // Also enable remember me option to remember tokens for a longer duration
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'permissions' => $user->getAllPermissions(),
            'roles' => $user->roles()->pluck('name'),
//            'expires_at' => Carbon::parse(
//                $tokenResult->token->expires_at
//            )->toDateTimeString()
        ]);
    }


    /**
     * @param Request $request
     * @return ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        //TODO: move this to middleware
        if (!$request->user()->canRegisterRole($request->base_role)) {
            return response()->json([
                'message' => 'User cannot register ' . $request->base_role
            ], 400);
        }

        $validator = RoleValidator::userValidator($request->all(), false);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $user = User::create(array_merge(
            $validator->validated(),
            [
                'last_updated_by' => auth()->id(),
                'password' => bcrypt($request->password)
            ]
        ));

//        $user = $this->createUser($request);

        //student login is disable until after admission
        if (!$user->isOfType('Student')) {
            $user->setStatus('Active');
        }

        return response()->json([
            'message' => 'Successfully created user!',
            'user' => $user
        ], 201);
    }

    //TODO: add logout from all devices api, with password/OTP confirmation

    public function logout(Request $request)
    {
        //On logout only current token will be revoked
        //TODO:: enable option to logout all users?
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    //TODO: Password reset functionality

    /**
     * @group Access Control
     * @return mixed
     */
    public function permissionsIndex()
    {
        return QueryBuilder::for(Permission::select('id', 'name'))
            ->allowedIncludes(['users', 'roles'])
            ->simplePaginate(15)
            ->appends(request()->query());
    }

    /**
     * @group Access Control
     * @return mixed
     */
    public function rolesIndex()
    {
        return QueryBuilder::for(Role::select('id', 'name')->with(
            ['permissions' => function (BelongsToMany $belongsToMany) {
                $belongsToMany->select(['id', 'name']);
            }]))
            ->allowedFields('permissions.id', 'permissions.name')
            ->allowedIncludes(['users', 'permissions'])
            ->simplePaginate(15)
            ->appends(request()->query());
    }

    /**
     * @group Access Control
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function rolesStore(Request $request)
    {
        $validator = RoleValidator::roleValidator($request->all());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //TODO: move to validation rule
        $validated_data = $validator->validated();

        if (!Hash::check($validated_data['password'], $request->user()->password)) {
            return response()->json(['message' => 'Invalid Password'], 400);
        }

        $role = Role::create(['name' => $validated_data['name'], 'guard_name' => 'api']);

        $role->syncPermissions($validated_data['permissions']);

        return response()->json([], 201);

//        return Role::select('id', 'name')->simplePaginate(15)
//            ->appends(request()->query());
    }

    /**
     * @group Access Control
     * @param Request $request
     * @param Role $role
     * @return mixed
     * @throws ValidationException
     */
    public function rolesUpdate(Request $request, Role $role)
    {
        $validator = RoleValidator::roleUpdateValidator($request->all(), $role);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validated_data = $validator->validated();

        //TODO: move to validation rule
        if (!Hash::check($validated_data['password'], $request->user()->password)) {
            return response()->json(['message' => 'Invalid Password'], 400);
        }

        if (array_key_exists('name', $validated_data)) {
            $role->update(['name' => $validated_data['name']]);
        }

        if (array_key_exists('permissions', $validated_data)) {
            $role->syncPermissions($validated_data['permissions']);
        }

        return response()->json([], 204);
    }


    /**
     * @group Access Control
     * @param Request $request
     * @param Role $role
     * @param User $user
     * @return mixed
     * @throws ValidationException
     */
    public function rolesAddUser(Request $request, Role $role, User $user)
    {
        //TODO: add check to verify roles of appropriate nature are being assigned to appropriate User.
        // Ex Teaching staff role cannot be assigned to a user of base role Student
        // This might be difficult as role names can be anything
        // One solution is Only Super Admin can assign roles and roles related to Student
        // (On Admission are automatically assigned by SMS system"
        $validator = RoleValidator::roleAddOrRemoveUserValidator($request->all());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //TODO: move to validation rule
        if (!Hash::check($validator->validated()['password'], $request->user()->password)) {
            return response()->json(['message' => 'Invalid Password'], 400);
        }

        $user->assignRole($role);

        return response()->json([
            "message" => $role->name . " Role successfully assigned to User!"
        ], 200);
    }

    /**
     *
     * @group Access Control
     * @param Request $request
     * @param Role $role
     * @param User $user
     * @return mixed
     * @throws ValidationException
     */
    public function rolesRemoveUser(Request $request, Role $role, User $user)
    {
        $validator = RoleValidator::roleAddOrRemoveUserValidator($request->all());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //TODO: move to validation rule
        if (!Hash::check($validator->validated()['password'], $request->user()->password)) {
            return response()->json(['message' => 'Invalid Password'], 400);
        }

        $user->removeRole($role);

        return response()->json([
            "message" => $role->name . " Role successfully removed from User"
        ], 200);
    }


    /**
     * @group Access Control
     * @param Request $request
     * @param Role $role
     * @return mixed
     * @throws ValidationException
     */
    public function rolesDelete(Request $request, Role $role)
    {
        $validator = RoleValidator::roleDeleteValidator($request->all(), $role);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //TODO: move to validation rule
        if (!Hash::check($validator->validated()['password'], $request->user()->password)) {
            return response()->json(['message' => 'Invalid Password'], 400);
        }

        //TODO:Test
        if (count($role->users)) {
            return response()->json(['message' => 'Role cannot be deleted as it is assigned to Users.'
                . ' Please remove role from respective Users and try again'], 400);
        }

        $role->delete();

        return response()->json([], 200);
    }

}
