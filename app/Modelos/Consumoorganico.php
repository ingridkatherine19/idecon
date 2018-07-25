<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumoorganico extends Model
{
    
    public $primaryKey='idConsumo';
    protected $table = 'consumoorganico';
    public $timestamps = false;

}
