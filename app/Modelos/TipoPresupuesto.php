<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoPresupuesto extends Model
{
    
    public $primaryKey='idTipo';
    protected $table = 'tipopresupuesto';
    public $timestamps = false;

}
