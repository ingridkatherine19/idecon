<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostoProvee extends Model
{
    
    public $primaryKey='idProvee';
    protected $table = 'costoprovee';
    public $timestamps = false;

}
