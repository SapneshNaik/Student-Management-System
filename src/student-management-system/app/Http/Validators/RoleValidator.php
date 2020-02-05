<?php


namespace App\Http\Validators;


use App\Constants;
use App\Models\User;
use App\Rules\Aadhaar;
use Illuminate\Validation\Rule;
use Validator;

class RoleValidator
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


    public static function studentValidator(array $data){

        return Validator::make($data, [
            'prefix' => ['required', Rule::in(Constants::PREFIXES)],
            'user_id' => 'required|exists:users,id|unique:students',
            'parent_id' => 'sometimes|exists:users,id',
            'first_name' => 'required|max:50|min:3|alpha',
            'middle_name' => 'nullable|max:50|min:3|alpha',
            'last_name' => 'required|max:50|min:3|alpha',
            'gender' => ['required', Rule::in(Constants::GENDER)],
            'caste' => 'required|max:30|min:3|string',
            'caste_category' => 'required|max:30|min:3|string',
            'religion' => ['required', Rule::in(Constants::RELIGIONS)],
            'blood_group' => ['required', Rule::in(Constants::BLOOD_GROUP)],
            'aadhaar_no' => ['required', 'digits:12', 'unique:students','numeric', new Aadhaar()],
            'passport_no' => 'sometimes|max:50|min:3|string',
        ]);
    }

    public static function updateStudentValidator(array $data, User $user){

        //DONE: Make sure parent ID can be set/updated only once [DONE]
        return Validator::make($data, [
            'prefix' => ['sometimes', Rule::in(Constants::PREFIXES)],
            'parent_id' => 'sometimes|exists:users,id',
            'first_name' => 'sometimes|max:50|min:3|alpha',
            'middle_name' => 'sometimes|max:50|min:3|alpha',
            'last_name' => 'sometimes|max:50|min:3|alpha',
            'gender' => ['sometimes', Rule::in(Constants::GENDER)],
            'caste' => 'sometimes|max:30|min:3|string',
            'caste_category' => 'sometimes|max:30|min:3|string',
            'religion' => ['sometimes', Rule::in(Constants::RELIGIONS)],
            'blood_group' => ['sometimes', Rule::in(Constants::BLOOD_GROUP)],
            'aadhaar_no' => ['sometimes',
                'digits:12',
                'unique:students,aadhaar_no,'.$user->student->id.'',
                'numeric',
                new Aadhaar()],
            'passport_no' => 'sometimes|max:50|min:3|string',
        ]);
    }

    public static function adminValidator(array $data){
        return Validator::make($data, [
            'prefix' => ['required', Rule::in(Constants::PREFIXES)],
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'is_super_admin' => 'sometimes|required|boolean',
        ]);
    }

    public static function updateAdminValidator(array $data){
        return Validator::make($data, [
            'prefix' => ['required', Rule::in(Constants::PREFIXES)],
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'is_super_admin' => 'sometimes|required|boolean',
        ]);
    }

    public static function staffValidator(array $data){

        return Validator::make($data, [
            'prefix' => ['required', Rule::in(Constants::PREFIXES)],
            'user_id' => 'required|exists:users,id|unique:staff',
            'first_name' => 'required|max:50|min:3|alpha',
            'middle_name' => 'nullable|max:50|min:3|alpha',
            'last_name' => 'required|max:50|min:3|alpha',
            'gender' => ['required', Rule::in(Constants::GENDER)],
            'aadhaar_no' => ['required', 'digits:12', 'unique:staff','numeric', new Aadhaar()],
            'passport_no' => 'sometimes|max:50|min:3|string',
        ]);
    }

    public static function updateStaffValidator(array $data, User $user){

        return Validator::make($data, [
            'prefix' => ['sometimes', Rule::in(Constants::PREFIXES)],
            'first_name' => 'sometimes|max:50|min:3|alpha',
            'middle_name' => 'sometimes|max:50|min:3|alpha',
            'last_name' => 'sometimes|max:50|min:3|alpha',
            'gender' => ['sometimes', Rule::in(Constants::GENDER)],
            'aadhaar_no' => ['sometimes',
                'digits:12',
                'unique:staff,aadhaar_no,'.$user->staff->id.'',
                'numeric',
                new Aadhaar()],
            'passport_no' => 'sometimes|max:50|min:3|string',
        ]);
    }

    public static function parentValidator(array $data){

        return Validator::make($data, [
            'user_id' => 'required|exists:users,id|unique:student_parents',
            'father_full_name' => 'required|max:150|min:3',
            'mother_full_name' => 'required|max:150|min:3',
            'staff_id' => 'sometimes|exists:users,id|unique:student_parents',
            'father_qualification' => 'required|max:50|min:3',
            'mother_qualification' => 'required|max:50|min:3',
            'father_contact_number' => 'required|max:13|min:10',
            'mother_contact_number' => 'sometimes|max:13|min:10',
            'father_profession' => 'required|max:50|min:1',
            'mother_profession' => 'sometimes|max:50|min:1',
            'father_designation' => 'required|max:50|min:1',
            'mother_designation' => 'sometimes|max:50|min:1',
            'father_net_annual_income' => 'required|numeric',
            'mother_net_annual_income' => 'sometimes|numeric',
            'father_pan' => 'required|max:10|min:1',
            'mother_pan' => 'sometimes|max:10|min:1',
            'is_father_alumni' => 'required|boolean',
            'is_mother_alumni' => 'sometimes|boolean',
            //TODO: fields below required if father or mother alumni, add in update also
            //TODO: not working debug
            'father_joining_year' => 'sometimes|required_if:is_father_alumni,true|digits:4',
            'mother_joining_year' => 'sometimes|required_if:is_mother_alumni,true|digits:4',
            'father_leaving_year' => 'sometimes|required_if:is_father_alumni,true|digits:4',
            'mother_leaving_year' => 'sometimes|required_if:is_mother_alumni,true|digits:4',
        ]);
    }

    public static function updateParentValidator(array $data){

        return Validator::make($data, [
            'father_full_name' => 'sometimes|max:150|min:3',
            'mother_full_name' => 'sometimes|max:150|min:3',
            //DONE: make sure staff ID can be updated only by a user with
            // Edit ALL PARENTS Permission [DONE]
            'staff_id' => 'sometimes|exists:users,id|unique:student_parents',
            'father_qualification' => 'sometimes|max:50|min:3',
            'mother_qualification' => 'sometimes|max:50|min:3',
            'father_contact_number' => 'sometimes|max:13|min:10',
            'mother_contact_number' => 'sometimes|max:13|min:10',
            'father_profession' => 'sometimes|max:50|min:1',
            'mother_profession' => 'sometimes|max:50|min:1',
            'father_designation' => 'sometimes|max:50|min:1',
            'mother_designation' => 'sometimes|max:50|min:1',
            'father_net_annual_income' => 'sometimes|max:50|min:1',
            'mother_net_annual_income' => 'sometimes|max:50|min:1',
            'father_pan' => 'sometimes|max:10|min:1',
            'mother_pan' => 'sometimes|max:10|min:1',
            'is_father_alumni' => 'sometimes|boolean',
            'is_mother_alumni' => 'sometimes|boolean',
            'father_joining_year' => 'sometimes|digits:4',
            'mother_joining_year' => 'sometimes|digits:4',
            'father_leaving_year' => 'sometimes|digits:4',
            'mother_leaving_year' => 'sometimes|digits:4',
        ]);
    }
}
