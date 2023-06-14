<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angle extends Model
{
    public $timestamps = false;
    public $table = 'angles';
    protected $fillable=['id','nick','name'];
}
