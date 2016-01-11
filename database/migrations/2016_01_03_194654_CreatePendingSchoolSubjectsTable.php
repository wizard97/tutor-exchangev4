<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingSchoolSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_school_subjects', function (Blueprint $table) {
          $table->increments('id');
          // legit refrence
          $table->integer('school_id')->unsigned()->nullable();
          $table->string('subject_name', 50);
          //pending refrence to new entry
          $table->integer('pending_school_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('school_subject_id')->unsigned()->nullable();
          // Refrence to proposal_table
          $table->integer('proposal_id')->unsigned()->index();
          $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('cascade');
          $table->boolean('to_delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pending_school_subjects');
    }
}
