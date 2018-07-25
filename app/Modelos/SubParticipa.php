<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubParticipa extends Model
{
    
    public $primaryKey='idParticipa';
    protected $table = 'subparticipa';
    public $timestamps = false;

}
