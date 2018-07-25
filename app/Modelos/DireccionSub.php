<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionSub extends Model
{
    
    public $primaryKey='idDireccion';
    protected $table = 'direccionsub';
    public $timestamps = false;

}