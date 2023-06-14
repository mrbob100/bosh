<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Display extends Model
{
    public $timestamps = false;
    public $table = 'displays';
    protected $fillable=['id','nick','name'];
}
