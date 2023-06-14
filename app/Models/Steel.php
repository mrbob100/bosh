<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steel extends Model
{
    public $timestamps = false;
    public $table = 'steels';
    protected $fillable=['id','nick','name'];
}
