<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    
    public $primaryKey='idDepartamento';
    protected $table = 'departamento';
    public $timestamps = false;

}
