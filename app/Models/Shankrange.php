<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shankrange extends Model
{
    public $timestamps = false;
    public $table = 'shankranges';
    protected $fillable=['id','nick','name'];
}
