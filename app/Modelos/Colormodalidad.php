<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colormodalidad extends Model
{
    
    public $primaryKey='id';
    protected $table = 'colormodalidad';
    public $timestamps = false;

}
