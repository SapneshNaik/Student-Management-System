<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    //

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

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    //TODO: student parent relationship

    public function parent()
    {
        return $this->belongsTo('App\Models\User');
    }
}


