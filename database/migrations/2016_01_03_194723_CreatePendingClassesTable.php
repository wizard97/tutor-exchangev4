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
          //pending refrence to new entry
          $table->integer('pending_school_id')->unsigned()->nullable();
          $table->integer('pending_subject_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('class_id')->unsigned()->nullable();
          // Refrence to proposal_table
          $table->integer('proposal_id')->unsigned()->index();
          $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('cascade');
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
