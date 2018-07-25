<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporte extends Model
{
    
    public $primaryKey='idReporte';
    protected $table = 'reporte';
    public $timestamps = false;

}
