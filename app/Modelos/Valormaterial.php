<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Valormaterial extends Model
{
    
    public $primaryKey='idValor';
    protected $table = 'valormaterial';
    public $timestamps = false;

}
