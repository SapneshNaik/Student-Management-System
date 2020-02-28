<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Helpers\ControllerHelper;
use App\Http\Validators\RoleValidator;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StaffController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function profile(Request $request)
    {
        return ControllerHelper::getProfile($request->user(), 'Staff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Paginator
     */
    public function index()
    {
        return  QueryBuilder::for(Staff::class)
            ->allowedFilters([AllowedFilter::exact('gender')])
            ->allowedIncludes(['user'])
            ->simplePaginate(15)
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
        //
        if (!$user->isOfType('Staff')) {
            return response()->json([
                'message' => $user->base_role . ' cannot have a Staff profile'],
                400);
        }

        $validator = RoleValidator::staffValidator(array_merge($request->all(), ['user_id' => $user->id]));

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Staff::create(array_merge($validator->validated(), ['user_id' => $user->id]));

        return response()->json([
            'message' => "Staff profile created successfully!"
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
        return ControllerHelper::getProfile($user, 'Staff');
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

        //check if user can edit
        if (ControllerHelper::userEditsOwnProfileOrHasPermission($request, $user, Constants::PERMISSIONS['EDIT_ALL_STAFF'])) {
            $validator = RoleValidator::updateStaffValidator($request->except('user_id'), $user);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user->staff->update($validator->validated());

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
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
