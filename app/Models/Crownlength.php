<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crownlength extends Model
{
    public $timestamps = false;
    public $table = 'crownlengths';
    protected $fillable=['id','nick','name'];
}
