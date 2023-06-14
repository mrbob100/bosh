<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rotationspeed extends Model
{
    public $timestamps = false;
    public $table = 'rotationspeeds';
    protected $fillable=['id','nick','name'];
}
