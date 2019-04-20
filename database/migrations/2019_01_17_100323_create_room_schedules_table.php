<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day');
            $table->string('time_starts');
            $table->string('time_end');
            $table->string('room');
            $table->integer('offering_id')->unsigned()->nullable();
            $table->integer('instructor')->unsigned()->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->integer('is_loaded')->default(0);
            $table->foreign('offering_id')
            ->references('id')->on('offerings_infos')
            ->onUpdate('cascade');
            
            $table->foreign('instructor')
            ->references('id')->on('users')
            ->onUpdate('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_schedules');
    }
}
