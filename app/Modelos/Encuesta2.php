<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encuesta2 extends Model
{
    
    public $primaryKey='idEncuesta';
    protected $table = 'encuesta2';
    public $timestamps = false;

}
