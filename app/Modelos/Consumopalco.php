<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumopalco extends Model
{
    
    public $primaryKey='idConsumo';
    protected $table = 'consumopalco';
    public $timestamps = false;

}
