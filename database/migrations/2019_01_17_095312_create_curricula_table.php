<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curricula', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_of_period');
            $table->string('curriculum_year');
            $table->string('program_code');
            $table->string('program_name');
            $table->string('control_code');
            $table->string('course_code');
            $table->string('course_name');
            $table->decimal('lec',5,2)->nullable();
            $table->decimal('lab',5,2)->nullable();
            $table->decimal('units',5,2)->nullable();
            $table->decimal('display_lec',5,2)->nullable();
            $table->decimal('display_lab',5,2)->nullable();
            $table->decimal('display_units',5,2)->nullable();
            $table->decimal('hours',5,2)->nullable();
            $table->string('level');
            $table->string('period');
            $table->decimal('srf', 10,2)->default(0.00);
            $table->integer('percent_tuition')->default(100);
            $table->integer('is_complab')->default(0);
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
        Schema::dropIfExists('curricula');
    }
}
