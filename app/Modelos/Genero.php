<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genero extends Model
{
    
    public $primaryKey='idGenero';
    protected $table = 'genero';
    public $timestamps = false;

}
