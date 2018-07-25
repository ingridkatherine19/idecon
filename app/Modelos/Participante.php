<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participante extends Model
{
    
    public $primaryKey='idParticipante';
    protected $table = 'participante';
    public $timestamps = false;

}
