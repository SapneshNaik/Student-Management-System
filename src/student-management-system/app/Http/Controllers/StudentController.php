<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Helpers\ControllerHelper;
use App\Http\Validators\RoleValidator;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
        return ControllerHelper::getProfile($request->user(), 'Student');
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
            ->allowedIncludes(['user', 'parent', 'parent.user', 'user.roles',  'user.updater'])
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

        //TODO: try to move to parent_id validation field
        if($request->has('parent_id') && !$this->isValidParent($request)) {
            return response()->json([
                'message' => 'Invalid Parent Id'
            ], 400);
        }

        $student = Student::create(array_merge($validator->validated(), ['user_id' => $user->id]));

        return response()->json([
            'message' => "Student profile created successfully!",
            'student' => $student
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
        return ControllerHelper::getProfile($user, 'Student');
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
        //make sure a profile exists before update
        //DONE: add this everywhere
        $show_response = $this->show($user);
        if($show_response->status() != 200){
            return $show_response;
        }

        //check if user can edit
        if (ControllerHelper::userEditsOwnProfileOrHasPermission($request, $user, Constants::PERMISSIONS['EDIT_ALL_STUDENTS'])) {
            $validator = RoleValidator::updateStudentValidator($request->except('user_id'), $user);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            if($request->has('parent_id') && !$this->isValidParent($request)) {
                return response()->json([
                    'message' => 'Invalid Parent Id'
                ], 400);
            }

            if($user->parent()->exists()){
                return response()->json([
                    'message' => 'Parent cannot be changed for a Student'
                ], 400);
            }

            $user->student->update($validator->validated());

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
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Student $student)
    {
        //
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isValidParent(Request $request): bool
    {
        $parent_id = $request->input('parent_id', null);
        //TODO: TEST
        return $parent_id == null ? false : User::find($parent_id)->isOfType('Parent');
    }
}
