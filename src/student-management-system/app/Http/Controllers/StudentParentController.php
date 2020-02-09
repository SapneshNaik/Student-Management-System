<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Helpers\ControllerHelper;
use App\Http\Validators\RoleValidator;
use App\Models\User;
use App\Models\StudentParent;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StudentParentController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function profile(Request $request)
    {
        return ControllerHelper::getProfile($request->user(), 'Parent');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Paginator
     */
    public function index()
    {
        //TODO: add "is_staff" scope attribute to StudentParent class to filter all Parent who are also staff
        return  QueryBuilder::for(StudentParent::class)
            ->allowedFilters([AllowedFilter::exact('is_father_alumni'),
                AllowedFilter::exact('is_mother_alumni')])
            ->allowedIncludes(['user', 'wards',  'wards.user'])
            ->simplePaginate(15);
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
        if (!$user->isOfType('Parent')) {
            return response()->json([
                'message' => $user->base_role . ' cannot have a Parent profile'],
                400);
        }

        $validator = RoleValidator::parentValidator(array_merge($request->all(), ['user_id' => $user->id]));

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        StudentParent::create(array_merge($validator->validated(), ['user_id' => $user->id]));

        return response()->json([
            'message' => "Parent profile created successfully!"
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
        return ControllerHelper::getProfile($user, 'Parent');
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
        //TODO: move this to a middleware
        $show_response = $this->show($user);
        if($show_response->status() != 200){
            return $show_response;
        }

        //check if user can edit
        // TODO: move this check also to a parameterized middleware
        if (ControllerHelper::userEditsOwnProfileOrHasPermission($request, $user, Constants::PERMISSIONS['EDIT_ALL_PARENTS'])) {

            $validator = RoleValidator::updateParentValidator($request->except('user_id'));

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            //TODO: Try to move it to validation
            if($request->has('staff_id') && !$request->user()->can(Constants::PERMISSIONS['EDIT_ALL_PARENTS'])){
                return response()->json([
                    'message' => $user->base_role . ' can not update Staff field. Please contact Admin'],
                    400);
            }

            $user->parent->update($validator->validated());

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
     * @param StudentParent $studentParent
     * @return void
     */
    public function destroy(StudentParent $studentParent)
    {
        //
    }
}
