<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Validators\RoleValidator;
use App\Models\Admin;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        if (!$request->user()->isOfType('Admin')) {
            return response()->json([
                'message' => $request->user()->base_role . ' does not have a student profile'],
                400);
        }

        return response()->json($request->user()->admin);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Paginator
     */
    public function index()
    {
        return  QueryBuilder::for(Admin::class)
            ->allowedFilters([AllowedFilter::exact('prefix'),
                AllowedFilter::exact('is_super_admin')])
            ->allowedIncludes(['user'])
            ->simplePaginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return JsonResponse
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

        $student = Admin::create(array_merge($request->all(), ['user_id' => $user->id,
            'is_super_admin' => false]));

        return response()->json([
            'message' => "Admin profile created successfully!"
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
        if (!$user->isOfType('Admin')) {
            return response()->json([
                'message' => $user->base_role . ' does not have a Admin profile'],
                400);
        }

        //TODO:: replcae with relationship [DONE]
        return $user->admin;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if (!$user->isOfType('Admin')) {
            return response()->json([
                'message' => $user->base_role . ' does not have a Admin profile'],
                400);
        }

        //If user being edited is a super user and its being done by someone other than the same user or another
        // super admin.
        if($user->hasRole(Constants::ROLES['SUPER_ADMIN'])
            && $user != $request->user()  //user being edited is not same as logged in user
            && !$request->user()->isSuperAdmin()){ //if logged in user is not a super
            // admin role
            return response()->json([
                'message' => $request->user()->base_role . ' cannot update a Super Admin profile'],
                400);
        }

        if ($request->user() == $user || $request->user()->can(Constants::PERMISSIONS['EDIT_ALL_ADMINS'])) {
            $update_data = $request->only('prefix',
                'first_name',
                'last_name',
                'is_super_admin');

            //TODO: TEST BELOW SCENARIO
            if(($request->has('is_super_admin') && !$request->user()->isSuperAdmin())){
                return response()->json([
                    'message' => $request->user()->base_role . ' cannot update a
                    Super Admin can upgrade or downgrade role'],
                    400);
            }

            $validator = RoleValidator::updateAdminValidator($update_data);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user->admin->update($update_data);

            return response()->json([], 204);

        } else {
            return response()->json([
                'message' => 'Invalid User Id'
            ], 400);
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
