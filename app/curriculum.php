<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class curriculum extends Model
{
    protected $table = 'curricula';
    
    protected $fillable = [
        'curriculum_year',
        'program_code',
        'program_name',
        'control_code',
        'course_code',
        'course_name',
        'lec',
        'lab',
        'units',
        'level',
        'period',
        'is_complab'
    ];
}
