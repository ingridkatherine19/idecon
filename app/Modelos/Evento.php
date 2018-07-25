<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    
    public $primaryKey='idEvento';
    protected $table = 'evento';
    use SoftDeletes;

}
