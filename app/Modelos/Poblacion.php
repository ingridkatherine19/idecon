<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poblacion extends Model
{
    
    public $primaryKey='idInfo';
    protected $table = 'infopoblacion';
    public $timestamps = false;

}
