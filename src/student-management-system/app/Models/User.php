<?php

namespace App\Models;

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

    function setStatus($status){
        $this->status = $status;
        $this->save();
    }

    function canLogin(): bool {
        return $this->status == 'Active';
    }
}
