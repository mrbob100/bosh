<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magnificate extends Model
{
    public $timestamps = false;
    public $table = 'magnifricates';
    protected $fillable=['id','nick','name'];
}
