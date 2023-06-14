<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vibration extends Model
{
    public $timestamps = false;
    public $table = 'vibrations';
    protected $fillable=['id','nick','name'];
}
