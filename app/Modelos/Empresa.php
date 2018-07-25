<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    
    public $primaryKey='idEmpresa';
    protected $table = 'empresa';
    use SoftDeletes;

}
