<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'prefix',
        'first_name',
        'last_name',
        'is_super_admin',
        'user_id'
    ];
}
