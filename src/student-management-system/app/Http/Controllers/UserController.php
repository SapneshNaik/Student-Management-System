<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Validators\AuthValidator;
use App\Models\User;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        //TODO:: Implement query filters

        // return DB::table('users')->simplePaginate(15); --> this ignores eloquent $hideen so use eloquent
        return User::simplePaginate(15);
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
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        // A user can update his own profile or all profiles if he has permission
        if ($request->user() == $user || $request->user()->can(Constants::PERMISSIONS['EDIT_ALL_USERS'])) {
            $update_data = $request->only('email',
                'phone_number',
                'alternate_phone_number',
                'password');

            $update_data['last_updated_by'] = auth()->id();

            $validator = AuthValidator::userUpdateValidator($update_data, $user);

            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }

//            return $update_data;
            $user->update($update_data);

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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
