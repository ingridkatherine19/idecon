<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngresoEvento extends Model
{
    
    public $primaryKey='idIngreso';
    protected $table = 'ingresoevento';
    public $timestamps = false;

}
