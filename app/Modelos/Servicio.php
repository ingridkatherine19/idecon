<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    
    public $primaryKey='idServicio';
    protected $table = 'servicio';
    public $timestamps = false;

}
