<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_levels', function (Blueprint $table) {
            $table->increments('id');
            //references tutor_id
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('user_id')->on('tutors')->onDelete('cascade');
            //references level_id
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
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
        Schema::drop('tutor_levels');
    }
}
