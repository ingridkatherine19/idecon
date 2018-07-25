<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Junta extends Model
{
    
    public $primaryKey='idJunta';
    protected $table = 'junta';
    public $timestamps = false;

}