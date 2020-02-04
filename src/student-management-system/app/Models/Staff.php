<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    //
    use SoftDeletes;

    protected $guarded = [''];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
