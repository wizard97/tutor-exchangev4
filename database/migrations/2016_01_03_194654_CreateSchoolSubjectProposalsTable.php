<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolSubjectProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_subject_proposals', function (Blueprint $table) {
          $table->increments('id');
          // legit refrence
          $table->integer('school_id')->unsigned()->nullable();
          $table->string('subject_name', 50);
          //pending refrence to new entry
          $table->integer('school_proposal_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('school_subject_id')->unsigned()->nullable();
          $table->boolean('to_delete')->default(0);

          // to allow polymorphic relation
          //$table->increments('proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('school_subject_proposals');
    }
}
