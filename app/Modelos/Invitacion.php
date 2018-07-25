<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitacion extends Model
{
    
    public $primaryKey='idInvitacion';
    protected $table = 'invitacion';
    public $timestamps = false;

}
