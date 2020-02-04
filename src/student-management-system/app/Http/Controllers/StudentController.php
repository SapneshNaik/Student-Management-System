<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Validators\RoleValidator;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StudentController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function profile(Request $request)
    {
        if (!$request->user()->isOfType('Student')) {
            return response()->json([
                'message' => $request->user()->base_role . ' does not have a Student profile'],
                400);
        }

        return response()->json($request->user()->student);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Paginator
     */
    public function index()
    {
        return  QueryBuilder::for(Student::class)
            ->allowedFilters([AllowedFilter::exact('gender'),
                AllowedFilter::exact('blood_group'),
                AllowedFilter::exact('caste'),
                AllowedFilter::exact('caste_category'),
                AllowedFilter::exact('religion'),])
            ->allowedIncludes(['user'])
            ->simplePaginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function store(Request $request, User $user)
    {
        //check if user can be a student
        if (!$user->isOfType('Student')) {
            return response()->json([
                'message' => $user->base_role . ' cannot have a Student profile'],
                400);
        }

        $validator = RoleValidator::studentValidator(array_merge($request->all(), ['user_id' => $user->id]));

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $student = Student::create(array_merge($request->all(), ['user_id' => $user->id]));

        return response()->json([
            'message' => "Student profile created successfully!"
        ], 201);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Student|JsonResponse
     */
    public function show(User $user)
    {
        if (!$user->isOfType('Student')) {
            return response()->json([
                'message' => $user->base_role . ' does not have a student profile'],
                400);
        }

        //TODO:: replcae with relationship [DONE]
        return $user->student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if (!$user->isOfType('Student')) {
            return response()->json([
                'message' => $user->base_role . ' does not have a student profile'],
                400);
        }

        //check if user can edit
        if ($request->user() == $user || $request->user()->can(Constants::PERMISSIONS['EDIT_ALL_STUDENTS'])) {
            $update_data = $request->only('prefix',
                'first_name',
                'middle_name',
                'last_name',
                'gender',
                'caste',
                'caste_category',
                'religion',
                'blood_group',
                'aadhaar_no',
                'passport_no');

            $validator = RoleValidator::updateStudentValidator($update_data, $user);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user->student->update($update_data);

            return response()->json([], 204);

        } else {
            return response()->json([
                'message' => 'Invalid User Id'
            ], 400);
        }


        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Student $student)
    {
        //
    }
}
