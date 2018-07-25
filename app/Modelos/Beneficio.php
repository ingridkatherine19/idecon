<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficio extends Model
{
    
    public $primaryKey='idBeneficio';
    protected $table = 'beneficio';
    public $timestamps = false;

}
