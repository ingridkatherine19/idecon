<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Costoactividad extends Model
{
    
    public $primaryKey='idCosto';
    protected $table = 'costoactividad';
    public $timestamps = false;

}
