<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accuracy extends Model
{
    public $timestamps = false;
    public $table = 'accuracies';
    protected $fillable=['id','nick','name'];
}
