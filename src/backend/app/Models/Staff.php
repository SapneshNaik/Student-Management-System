<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    //
    use SoftDeletes;

    protected $guarded = [''];

    protected $appends = ['linked_parent_id'];

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

    public function linkedParent()
    {
        return $this->hasOne('App\Models\StudentParent', 'staff_linked_id', 'user_id');
    }

    public function getLinkedParentIdAttribute(){
        if($this->linkedParent()->exists()){
            return $this->linkedParent->user_id;
        } else {
            return null;
        }
    }
}
