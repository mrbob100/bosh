<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Differenceprod extends Model
{
    public $timestamps = false;
    public $table = 'differenceprods';
    protected $fillable=['id','name'];
}
