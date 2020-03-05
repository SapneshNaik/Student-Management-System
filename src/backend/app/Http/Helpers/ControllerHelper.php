<?php


namespace App\Http\Helpers;


use App\Constants;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerHelper
{

    /**
     * @param User $user
     * @param $role
     * @return JsonResponse
     */
    static function getProfile(User $user, $role): JsonResponse
    {
        if (!$user->isOfType($role)) {
            return response()->json([
                'message' => auth()->user()->base_role . ' does not have a ' . $role . ' profile'],
                400);
        }

        //TODO: Allow fetching only required fields and relationships (parent,user)
        //TODO: Test when $role can finally login
        if ($user->$role()->exists()) {
            return response()->json($user->$role);
        } else {
            return response()->json([
                //TODO: replace admin with Roles that have this permission
                'message' => $user->base_role . ' Profile not yet created. Please contact Admin'],
                404);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $permission
     * @return bool
     */
    static function userEditsOwnProfileOrHasPermission(Request $request, User $user, $permission): bool
    {
        return ($request->user()->is($user) || $request->user()->can($permission));
    }
}
