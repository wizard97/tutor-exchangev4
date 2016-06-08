<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_proposals', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('school_id')->unsigned()->nullable();
          $table->integer('subject_id')->unsigned()->nullable();
          $table->string('class_name', 50);
          //pending refrence to new entry
          $table->integer('school_proposal_id')->unsigned()->nullable();
          $table->integer('subject_proposal_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('class_id')->unsigned()->nullable();
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
        Schema::drop('class_proposals');
    }
}
