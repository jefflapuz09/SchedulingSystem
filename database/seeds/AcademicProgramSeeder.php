<?php

use Illuminate\Database\Seeder;

class AcademicProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => ' ',
           'program_code' => 'BSIT',
           'program_name' => 'Bachelor of Science in Information Technology',
        ]);
        
        \App\academic_programs::create([
           'academic_type' => 'College',
           'department' => ' ',
           'program_code' => 'BSCS',
           'program_name' => 'Bachelor of Science in Computer Science',
        ]);
    }
}
