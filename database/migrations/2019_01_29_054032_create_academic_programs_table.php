<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('academic_type');
            $table->string('academic_code')->nullable();
            $table->string('academic_name')->nullable();
            $table->string('department');
            $table->string('program_code')->nullable();
            $table->string('program_name')->nullable();
            $table->string('level')->nullable();
            $table->string('strand')->nullable();
            $table->string('strand_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_programs');
    }
}
