<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Validators\RoleValidator;
use App\Models\Student;
use App\Models\User;
use App\Staff;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        if (!$request->user()->isOfType('Staff')) {
            return response()->json([
                'message' => $request->user()->base_role . ' does not have a Staff profile'],
                400);
        }

        return response()->json($request->user()->staff);
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

        Staff::create(array_merge($request->all(), ['user_id' => $user->id]));

        return response()->json([
            'message' => "Staff profile created successfully!"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Staff $staff
     * @param User $user
     * @return JsonResponse
     */
    public function show(Staff $staff, User $user)
    {
        //
        if (!$user->isOfType('Staff')) {
            return response()->json([
                'message' => $user->base_role . ' does not have a Staff profile'],
                400);
        }

        //TODO:: replcae with relationship [DONE]
        return $user->staff;
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
        if (!$user->isOfType('Student')) {
            return response()->json([
                'message' => $user->base_role . ' does not have a Staff profile'],
                400);
        }

        //check if user can edit
        if ($request->user() == $user || $request->user()->can(Constants::PERMISSIONS['EDIT_ALL_STAFF'])) {
            $update_data = $request->only('prefix',
                'first_name',
                'middle_name',
                'last_name',
                'gender',
                'aadhaar_no',
                'passport_no');

            $validator = RoleValidator::updateStudentValidator($update_data, $user);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user->staff->update($update_data);

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
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
