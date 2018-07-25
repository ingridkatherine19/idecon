<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciudad extends Model
{
    
    public $primaryKey='idCiudad';
    protected $table = 'ciudad';
    public $timestamps = false;

}
