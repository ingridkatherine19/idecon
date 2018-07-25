<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionActividad extends Model
{
    
    public $primaryKey='idDireccion';
    protected $table = 'direccionactividad';
    public $timestamps = false;

}
