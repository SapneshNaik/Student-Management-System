<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Validators\RoleValidator;
use App\Models\User;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Paginator
     */
    public function index()
    {
        //DONE:: Implement query filters [DONE]

        // return DB::table('users')->simplePaginate(15); --> this ignores eloquent $hideen so use eloquent
//        return User::simplePaginate(15);
        return  QueryBuilder::for(User::class)
            ->allowedFilters([AllowedFilter::exact('email'),
                AllowedFilter::exact('base_role'),
                AllowedFilter::exact('phone_number'),
                AllowedFilter::exact('alternate_phone_number'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('email'),])
            ->allowedIncludes(['student', 'admin', 'staff', 'parent'])
            ->simplePaginate(15);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
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
        //DONE:Add a check where only a super admin could update a super admins details (all details)

        if($user->isSuperAdmin() && !$request->user()->isSuperAdmin() ){
            return response()->json([
                'message' => $request->user()->base_role.' cannot update '.Constants::ROLES['SUPER_ADMIN'].' profile'
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
                'message' => $request->user()->base_role.' does not have the permission to update other '.$user->base_role.' profile'
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
