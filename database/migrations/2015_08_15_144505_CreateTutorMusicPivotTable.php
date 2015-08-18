<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorMusicPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_music', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('tutor_id')->unsigned();
          $table->foreign('tutor_id')->references('user_id')->on('tutors')->onDelete('cascade');
          //references level_id
          $table->integer('music_id')->unsigned();
          $table->foreign('music_id')->references('id')->on('music')->onDelete('cascade');
          $table->integer('years_experiance')->unsigned();
          $table->integer('upto_years')->unsigned();
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
        Schema::drop('tutor_music');
    }
}
