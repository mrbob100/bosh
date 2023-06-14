<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTool extends Model
{
    public $table='typetools';
    protected $primaryKey='id';
    public $timestamps = false;
    protected $fillable=['id','nick','name'];
    public function products()
    {
        return $this->hasMany('App\Models\Product','type','id');
    }
}
