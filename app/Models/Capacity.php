<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    public $timestamps = false;
    public $table = 'capacities';
    protected $fillable=['id','nick','name'];
}
