<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encuesta extends Model
{
    
    public $primaryKey='idEncuesta';
    protected $table = 'encuesta';
    public $timestamps = false;

}
