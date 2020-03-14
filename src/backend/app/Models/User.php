<?php

namespace App\Models;

use App\Constants;
use Composer\Package\Package;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Str;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes, HasRoles;

    protected $guard_name = 'api';
    protected $appends = ['all_permissions', 'communication_address', 'permanent_address', 'name'];

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

    public function addresses(){
        return $this->hasMany('App\Models\Address');
    }

    public function updater(){
        return $this->belongsTo('App\Models\User', 'last_updated_by', 'id');
    }

    public function profile(){
        switch ($this->base_role){
            case "Admin":
                return $this->admin;
            case "Staff":
                return $this->staff;
            case "Student":
                return $this->student;
            case "Parent":
                return $this->parent;
            default:
                return null;
        }
    }

    public function getAllPermissionsAttribute(){
        return $this->getAllPermissions()->map->only(['id', 'name']);
    }

    public function  getCommunicationAddressAttribute(){
        return $this->addresses()->where('type', Constants::ADDRESS_TYPES[0])->first();
    }

    public function  getPermanentAddressAttribute(){
        return $this->addresses()->where('type', Constants::ADDRESS_TYPES[1])->first();
    }

    public function getNameAttribute(){

        if($this->profile() == null){
            return $this->login_id;
        }

        if(!$this->profile() instanceof StudentParent){
            return Str::title($this->profile()->first_name." ". $this->profile()->last_name);
        } else {
            return Str::title($this->profile()->father_full_name);
        }
    }
}
