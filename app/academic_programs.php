<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class academic_programs extends Model
{
    protected $table = 'academic_programs';
    
    protected $fillable = [
        'academic_type',
        'program_code',
        'program_name',
    ];
}
