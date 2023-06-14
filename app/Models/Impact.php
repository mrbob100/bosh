<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impact extends Model
{
    public $timestamps = false;
    public $table = 'impacts';
    protected $fillable=['id','nick','name'];
}
