<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lugar extends Model
{
    
    public $primaryKey='idLugar';
    protected $table = 'lugar';
    public $timestamps = false;

}
