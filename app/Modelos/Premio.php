<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Premio extends Model
{
    
    public $primaryKey='idPremio';
    protected $table = 'premio';
    public $timestamps = false;

}
