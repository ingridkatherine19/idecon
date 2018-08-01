<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agrupacion extends Model
{
    
    public $primaryKey='idAgrupacion';
    protected $table = 'agrupaciones';
    use SoftDeletes;

}
