<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividadparticipante extends Model
{
    
    public $primaryKey='id';
    protected $table = 'actividadparticipante';
    public $timestamps = false;

}
