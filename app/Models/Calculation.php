<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    public $timestamps = false;
    public $table = 'calculations';
    protected $fillable=['id','nick','name'];
}
