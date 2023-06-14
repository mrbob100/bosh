<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Containervol extends Model
{
    public $timestamps = false;
    public $table = 'containervols';
    protected $fillable=['id','nick','name'];
}
