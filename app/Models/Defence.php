<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defence extends Model
{
    public $timestamps = false;
    public $table = 'defences';
    protected $fillable=['id','nick','name'];
}
