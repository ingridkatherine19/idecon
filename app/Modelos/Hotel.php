<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    
    public $primaryKey='idHotel';
    protected $table = 'hotel';
    public $timestamps = false;

}
