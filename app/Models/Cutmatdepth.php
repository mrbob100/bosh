<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cutmatdepth extends Model
{
    public $timestamps = false;
    public $table = 'cutmatdepths';
    protected $fillable=['id','nick','name'];
}
