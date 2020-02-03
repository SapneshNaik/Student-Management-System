<?php


namespace App\Http\Validators;


use App\Constants;
use Illuminate\Validation\Rule;
use Validator;

class AuthValidator
{
    public static function userValidator(array $data, $is_super_admin){

//        $req = $is_super_admin ? 'nullable' : 'required';
        $req = 'nullable';
        return Validator::make($data, [
            'email' => 'required|email|unique:users|max:50',
            'login_id' => 'required|max:50|unique:users',
            'phone_number' => 'required|max:13',
            'alternate_phone_number' => 'nullable|max:13',
            'base_role' => ['required', Rule::in(Constants::BASE_ROLE)],
            'last_updated_by' => ''.$req.'|numeric|exists:users,id',
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
}
