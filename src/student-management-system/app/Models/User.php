<?php

namespace App\Models;

use App\Constants;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes, HasRoles;

    protected $guard_name = 'api';


    protected $fillable = [
        'login_id',
        'email',
        'phone_number',
        'alternate_phone_number',
        'password',
        'base_role',
        'last_updated_by'
    ];


    /**p
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at', 'created_at', 'updated_at'
    ];

    protected $casts = ['is_super_admin' => 'boolean'];


    function setStatus($status){
        $this->status = $status;
        $this->save();
    }

    function canLogin(): bool {
        return $this->status == 'Active';
    }

    function canRegisterRole($role_type): bool {
        switch ($role_type){
            case 'Admin' :
                return $this->can(Constants::PERMISSIONS['REGISTER_ADMIN']);
            case 'Staff' :
                return $this->can(Constants::PERMISSIONS['REGISTER_STAFF']);
            case 'Student' :
                return $this->can(Constants::PERMISSIONS['REGISTER_STUDENT']);
            case 'Parent' :
                return $this->can(Constants::PERMISSIONS['REGISTER_PARENT']);
            default:
                return false;
        }
    }

    public function isOfType(string $string): bool
    {
        return $this->base_role == $string;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Constants::ROLES['SUPER_ADMIN']);
    }

    public function student(){
        return $this->hasOne('App\Models\Student');
    }

    public function staff(){
        return $this->hasOne('App\Models\Staff');
    }

    public function admin(){
        return $this->hasOne('App\Models\Admin');
    }

    public function parent(){
        return $this->hasOne('App\Models\StudentParent');
    }

    public function getAllPermissionsAttribute(){
        return $this->getAllPermissions()->map->only(['id', 'name']);
//        return $this->getAllPermissions()->filter(function ($value, $key){
////            print($key);
//            error_log($value);
//
//            return $key == 'id' || $key == 'name';
//        });
    }
}
