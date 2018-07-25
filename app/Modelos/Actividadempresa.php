<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadEmpresa extends Model
{
    
    public $primaryKey='id';
    protected $table = 'actividadempresa';
    public $timestamps = false;

}
