<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Validators\RoleValidator;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Base User management
 *
 * APIs for managing base user profiles
 */
class UserController extends Controller
{

    /**
     * Get logged-in user's profile
     *
     * @authenticated
     * @queryParam include include a relationship in response. Example: roles
     * @queryParam append append a computed attribute to response. Example: all_permissions
     * @responseFile responses/user.profile.json
     *
     * @response 401 {
     * "message": "Unauthenticated."
     * }
     * @param Request $request
     * @return Model|object|QueryBuilder
     */
    public function profile(Request $request)
    {
        return QueryBuilder::for(User::where('id', $request->user()->id)) // base query instead of model
        ->allowedFields(['roles.id', 'roles.name'])
            ->allowedIncludes(['roles', 'student', 'staff', 'admin', 'parent'])
            ->allowedAppends(['all_permissions'])
            ->first();
    }

    /**
     * List all User profiles
     *
     * This endpoint supports pagination
     * "View All Users" permission is required to access this endpoint.
     *
     * @authenticated
     * @queryParam filter_base_role include only specified base_role in response. Example:Student,Parent
     * @queryParam filter_phone_number include only specified phone_number in response. Example:7760041698,
     * @queryParam filter_alternate_phone_number include only specified alternate_phone_number in response. Example:8892497966,
     * @queryParam filter_status include only specified status in response. Example:Active,
     * @queryParam filter_last_updated_by include only specified last_updated_by in response. Example:1,
     * @queryParam filter_email include only specified email in response. Example:sapnesh@kerneldev.com,
     * @queryParam include include specified relationship in response. Example:student,staff,parent,roles,permissions
     *
     * @responseFile responses/users.index.json
     *
     * @return Paginator
     */
    public function index()
    {
        //DONE:: Implement query filters [DONE]

        // return DB::table('users')->simplePaginate(15)
            ->appends(request()->query()); --> this ignores eloquent $hideen so use eloquent
//        return User::simplePaginate(15);
        return QueryBuilder::for(User::class)
            ->allowedFilters([AllowedFilter::exact('email'),
                AllowedFilter::exact('base_role'),
                AllowedFilter::exact('phone_number'),
                AllowedFilter::exact('alternate_phone_number'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('last_updated_by'),
                AllowedFilter::exact('email'),])
            ->allowedIncludes(['student', 'admin', 'staff', 'parent', 'roles', 'permissions'])
            ->simplePaginate(15)
            ->appends(request()->query());
    }


    /**
     * Get Any User's profile
     *
     * "View All Users" permission is required to access this endpoint
     *
     * @authenticated
     * @queryParam include include a relationship in response. Example: roles
     * @queryParam append append a computed attribute to response. Example: all_permissions
     * @responseFile responses/user.profile.json
     *
     * @response 401 {
     * "message": "Unauthenticated."
     * }
     *
     * @response 403 {
     * "message": "You do not have the required authorization."
     * }
     *
     * @param User $user
     * @return Model|object|QueryBuilder
     */
    public function show(User $user)
    {
        //TODO: add relation to all other model show methods
        return QueryBuilder::for(User::where('id', $user->id)) // base query instead of model
        ->allowedIncludes(['student', 'admin', 'staff', 'parent', 'roles', 'permissions'])
            ->allowedAppends(['all_permissions'])
            ->first();
    }

    /**
     * Update User Profile Details
     *
     * A User can update their own profile or "Edit All Users" permission is required to edit other User's details
     * Only A Super Admin can update another Super Admin's Profile
     *
     * @authenticated
     *
     * @bodyParam email email A valid Email address. Must not be already in use. Example: sapnesh@kerneldev.com
     * @bodyParam phone_number string A valid Phone Number. Must be 10-13 digits long. Example: 7760041698
     * @bodyParam alternate_phone_number string A valid Phone Number. Must be 10-13 digits long.
     * @bodyParam password string A 6 digit password.
     * @bodyParam password_confirmation string same as password.
     *
     * @response 204 {
     * }
     *
     * @response 401{
     * "message": "Unauthenticated."
     * }
     *
     * @response 403 {
     * "message": "Staff cannot update Super Admin profile"
     * }
     *
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        //DONE:Add a check where only a super admin could update a super admins details (all details)

        if ($user->isSuperAdmin() && !$request->user()->isSuperAdmin()) {
            return response()->json([
                'message' => $request->user()->base_role . ' cannot update ' . Constants::ROLES['SUPER_ADMIN'] . ' profile'
            ], 403);
        }

        // A user can update his own profile or all profiles if he has permission
//        return $request->user();
        if ($request->user()->is($user) || $request->user()->can(Constants::PERMISSIONS['EDIT_ALL_USERS'])) {
            $update_data = $request->only('email',
                'phone_number',
                'alternate_phone_number',
                'password');
            //cannot update is_super_admin because we're not taking it

            $update_data['last_updated_by'] = $request->user()->id;

            $validator = RoleValidator::userUpdateValidator($update_data, $user);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user->update($update_data);

            return response()->json([], 204);

        } else {
            return response()->json([
                'message' => $request->user()->base_role . ' does not have the permission to update other ' . $user->base_role . ' profile'
            ], 403);
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
