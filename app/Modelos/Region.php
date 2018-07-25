<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    
    public $primaryKey='idRegion';
    protected $table = 'region';
    public $timestamps = false;

}
