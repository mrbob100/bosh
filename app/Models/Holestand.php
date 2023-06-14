<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holestand extends Model
{
    public $timestamps = false;
    public $table = 'holestands';
    protected $fillable=['id','nick','name'];
}
