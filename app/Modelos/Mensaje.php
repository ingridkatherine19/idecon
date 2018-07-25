<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mensaje extends Model
{
    
    public $primaryKey='idMensaje';
    protected $table = 'mensaje';
    public $timestamps = false;

}
