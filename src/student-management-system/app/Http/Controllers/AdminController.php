<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Helpers\ControllerHelper;
use App\Http\Validators\RoleValidator;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function profile(Request $request)
    {
        return ControllerHelper::getProfile($request->user(), 'Admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Paginator
     */
    public function index()
    {
        return  QueryBuilder::for(Admin::class)
            ->allowedFilters([
                AllowedFilter::exact('prefix'),
                AllowedFilter::exact('is_super_admin')])
            ->allowedIncludes(['user', 'user.roles', 'user.updater'])
            ->paginate(15)
            ->appends(request()->query());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request, User $user)
    {
        if (!$user->isOfType('Admin')) {
            return response()->json([
                'message' => $user->base_role . ' cannot have a Admin profile'],
                400);
        }

        $validator = RoleValidator::adminValidator(array_merge($request->all(), ['user_id' => $user->id,
            'is_super_admin' => false]));

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $admin = Admin::create(array_merge($validator->validated(), ['user_id' => $user->id,
            'is_super_admin' => false]));

        return response()->json([
            'message' => "Admin profile created successfully!",
            'admin' => $admin
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return ControllerHelper::getProfile($user, 'Admin');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        $show_response = $this->show($user);
        if($show_response->status() != 200){
            return $show_response;
        }

        //If user being edited is a super user and its being done by someone other than the same user or another
        // super admin.

        //TODO: refactor, move this into a middleware which takes inout and can be applied to all update routes
        if($user->isSuperAdmin() && !$request->user()->isSuperAdmin()){ //if logged in user is not a super
            // admin role
            return response()->json([
                'message' => $request->user()->base_role . ' cannot update a '.Constants::ROLES['SUPER_ADMIN'].' profile'],
                400);
        }

        if (ControllerHelper::userEditsOwnProfileOrHasPermission($request, $user, Constants::PERMISSIONS['EDIT_ALL_ADMINS'])) {
            //TODO: TEST BELOW SCENARIO
            if(($request->has('is_super_admin') && !$request->user()->isSuperAdmin())){
                return response()->json([
                    'message' => $request->user()->base_role . ' cannot upgrade or downgrade role'],
                    400);
            }

            $validator = RoleValidator::updateAdminValidator($request->except('user_id'));

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user->admin->update($validator->validated());

            return response()->json([], 204);

        } else {
            return response()->json([
                'message' => $request->user()->base_role.' does not have the permission to update other '.$user->base_role.' profile'
            ], 403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
