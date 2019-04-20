<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtrRoom extends Model
{
    protected $table = 'ctr_rooms';
    
    protected $fillable = [
        'room',
        'building'
    ];
}
