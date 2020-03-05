<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentParent extends Model
{
    //TODO: UNDO THIS!!
    use SoftDeletes;

    protected $guarded = [''];

    /**p
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at', 'id'
    ];

    protected $casts = [['is_father_alumni' => 'boolean', 'is_mother_alumni' => 'boolean']];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    //TODO: student parent relationship

    //TODO: TEST
    public function wards()
    {
        return $this->hasMany('App\Models\Student', 'parent_id', 'user_id');
    }
}
