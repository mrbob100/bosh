<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cutdepth extends Model
{
    public $timestamps = false;
    public $table = 'cutdepths';
    protected $fillable=['id','nick','name'];
}
