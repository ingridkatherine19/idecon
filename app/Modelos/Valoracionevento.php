<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Valoracionevento extends Model
{
    
    public $primaryKey='idValoracion';
    protected $table = 'valoracionevento';
    public $timestamps = false;

}
