<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtrSection extends Model
{
    protected $table = 'ctr_sections';
    
    protected $fillable = [
        'program_code',
        'level',
        'section'
    ];
}
