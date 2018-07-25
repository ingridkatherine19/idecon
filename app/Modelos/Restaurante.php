<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurante extends Model
{
    
    public $primaryKey='idRestaurante';
    protected $table = 'restaurante';
    public $timestamps = false;

}
