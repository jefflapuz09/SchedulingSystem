<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instructor_id')->unsigned();
            $table->string('college')->nullable();
            $table->string('department')->nullable();
            $table->string('gender')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('tel_no')->nullable();
            $table->string('cell_no')->nullable();
            $table->string('degree_status')->nullable();
            $table->string('program_graduated')->nullable();
            $table->string('employee_type')->nullable();
            $table->foreign("instructor_id")->references("id")
                    ->on("users")->onUpdate("cascade");
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
        Schema::dropIfExists('instructors_infos');
    }
}
