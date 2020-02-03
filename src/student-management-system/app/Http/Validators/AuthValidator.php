<?php


namespace App\Http\Validators;


use App\Constants;
use App\Models\User;
use Illuminate\Validation\Rule;
use Validator;

class AuthValidator
{
    public static function userValidator(array $data, $is_super_admin){

//        $req = $is_super_admin ? 'nullable' : 'required';
        $req = 'nullable';
        return Validator::make($data, [
            'email' => 'required|email|unique:users|max:50',
            'login_id' => 'required|max:50|unique:users|alpha_dash',
            'phone_number' => 'required|max:13|min:10',
            'alternate_phone_number' => 'nullable|max:13|min:10',
            'base_role' => ['required', Rule::in(Constants::BASE_ROLE)],
            'password' => 'required|confirmed|string|min:6',
        ]);
    }

    public static function adminValidator(array $data){
        return Validator::make($data, [
            'prefix' => ['required', Rule::in(Constants::PREFIXES)],
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'is_super_admin' => 'sometimes|required|boolean',
            'user_id' => 'required|exists:users,id',
        ]);
    }

    public static function userUpdateValidator(array $data, User $user){

//        $req = $is_super_admin ? 'nullable' : 'required';
        $req = 'nullable';
        return Validator::make($data, [
            'email' => 'sometimes|email|unique:users,email,'.$user->id.'|max:50',
            'phone_number' => 'sometimes|max:13|min:10',
            'alternate_phone_number' => 'sometimes|max:13|min:10',
            'password' => 'sometimes|confirmed|string|min:6',
        ]);
    }
}
