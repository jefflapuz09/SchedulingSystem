<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(AcademicProgramSeeder::class);
         $this->call(CurriculaSeeder::class);
         $this->call(SectionSeeder::class);
         $this->call(RoomSeeder::class);
    }
}
