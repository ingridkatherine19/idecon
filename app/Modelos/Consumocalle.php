<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumocalle extends Model
{
    
    public $primaryKey='idConsumo';
    protected $table = 'consumocalle';
    public $timestamps = false;

}
