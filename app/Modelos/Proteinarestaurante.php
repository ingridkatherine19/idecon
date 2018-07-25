<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proteinarestaurante extends Model
{
    
    public $primaryKey='idProteina';
    protected $table = 'proteinarestaurante';
    public $timestamps = false;

}
