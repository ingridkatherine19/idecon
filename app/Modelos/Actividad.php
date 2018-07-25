<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model
{
    
    public $primaryKey='idActividad';
    protected $table = 'actividad';
    public $timestamps = false;

}
