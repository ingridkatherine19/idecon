<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Palco extends Model
{
    
    public $primaryKey='idPalco';
    protected $table = 'palco';
    public $timestamps = false;

}
