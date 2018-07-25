<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    
    public $primaryKey='idCargo';
    protected $table = 'cargo';
    public $timestamps = false;

}
