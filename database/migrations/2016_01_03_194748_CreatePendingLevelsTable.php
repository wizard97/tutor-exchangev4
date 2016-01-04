<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_levels', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('class_id')->unsigned()->nullable();
          $table->integer('level_num')->unsigned();
          $table->string('level_name', 50);
          //pending refrence
          $table->integer('pending_class_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('level_id')->unsigned()->nullable();
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('pending_levels');
    }
}
