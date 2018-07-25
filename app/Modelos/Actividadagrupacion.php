<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividadagrupacion extends Model
{
    
    public $primaryKey='id';
    protected $table = 'actividadagrupacion';
    public $timestamps = false;

}
