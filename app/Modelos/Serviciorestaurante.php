<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serviciorestaurante extends Model
{
    
    public $primaryKey='idServicio';
    protected $table = 'serviciorestaurante';
    public $timestamps = false;

}
