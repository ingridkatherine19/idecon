<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pregunta extends Model
{
    
    public $primaryKey='idPregunta';
    protected $table = 'pregunta';
    public $timestamps = false;

}
