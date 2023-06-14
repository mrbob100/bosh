<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qntimpact extends Model
{
    public $timestamps = false;
    public $table = 'qntimpacts';
    protected $fillable=['id','nick','name'];
}
