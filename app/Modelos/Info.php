<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info extends Model
{
    
    public $primaryKey='idInfo';
    protected $table = 'info';
    public $timestamps = false;

}
