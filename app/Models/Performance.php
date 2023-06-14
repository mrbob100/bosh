<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    public $timestamps = false;
    public $table = 'performances';
    protected $fillable=['id','nick','name'];
}
