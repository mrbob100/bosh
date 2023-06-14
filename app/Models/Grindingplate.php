<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grindingplate extends Model
{
    public $timestamps = false;
    public $table = 'grindingplates';
    protected $fillable=['id','nick','name'];
}
