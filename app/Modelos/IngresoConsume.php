<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngresoConsume extends Model
{
    
    public $primaryKey='idConsume';
    protected $table = 'ingresoconsume';
    public $timestamps = false;

}
