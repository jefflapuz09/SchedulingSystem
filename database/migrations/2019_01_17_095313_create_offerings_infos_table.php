<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferingsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offerings_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_type')->nullable();
            $table->integer('curriculum_id')->unsigned();
            $table->decimal('description',5,2)->nullable();
            $table->string('section_name');
            $table->string('level');
            $table->timestamps();
            
            $table->foreign('curriculum_id')
                    ->references('id')->on('curricula')
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
        Schema::dropIfExists('offerings_infos_tables');
    }
}
