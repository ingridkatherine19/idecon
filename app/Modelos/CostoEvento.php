<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostoEvento extends Model
{
    
    public $primaryKey='idCosto';
    protected $table = 'costoevento';
    public $timestamps = false;

}
