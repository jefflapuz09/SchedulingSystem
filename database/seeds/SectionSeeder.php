<?php

use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\CtrSection::create([
            'program_code' => 'BSIT',
            'level' => '1st Year',
            'section_name' => 'BSIT-1',
        ]);
                
        \App\CtrSection::create([
            'program_code' => 'BSIT',
            'level' => '1st Year',
            'section_name' => 'BSIT-2'
        ]);
    }
}
