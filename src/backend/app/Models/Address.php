<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    //
    use SoftDeletes;

    protected $guarded = [''];

    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at', 'id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
