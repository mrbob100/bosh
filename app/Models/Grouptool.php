<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grouptool extends Model
{
    public $timestamps = false;
    public $table = 'grouptools';
    protected $fillable=['id','nick','name'];


    public function products()
    {
        return $this->hasMany('App\Models\Product','groupTools','id');
    }
}
