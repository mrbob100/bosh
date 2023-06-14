<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    public $timestamps = false;
    public $table = 'worktimes';
    protected $fillable=['id','nick','name'];
}
