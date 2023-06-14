<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   protected $fillable =['id','name'];

    public function users()
    {
        return $this->belongsToMany('App\User','role_user','role_id','user_id');
    }
}
