<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scaffold extends Model
{
    public $timestamps = false;
    public $table = 'scaffolds';
    protected $fillable=['id','nick','name'];
}
