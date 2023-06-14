<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newproduct extends Model
{

    protected $fillable=['id','name','path','product_id','created_at'];

    public function products()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

}
