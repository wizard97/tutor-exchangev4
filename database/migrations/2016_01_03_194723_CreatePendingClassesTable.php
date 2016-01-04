<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_classes', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('school_id')->unsigned()->nullable();
          $table->integer('subject_id')->unsigned()->nullable();
          $table->string('class_name', 50);
          //pending refrence
          $table->integer('pending_school_id')->unsigned()->nullable();
          $table->integer('pending_subject_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('class_id')->unsigned()->nullable();
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
        Schema::drop('pending_classes');
    }
}
