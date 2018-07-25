<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoActividad extends Model
{
    
    public $primaryKey='idEventoActividad';
    protected $table = 'eventoactividad';
    public $timestamps = false;

}
