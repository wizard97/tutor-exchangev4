<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_proposals', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          //$table->integer('class_id')->unsigned()->nullable();
          $table->integer('level_num')->unsigned();
          $table->string('level_name', 50);
          //pending refrence to new entry
          $table->integer('class_proposal_id')->unsigned();
          $table->foreign('class_proposal_id')->references('id')->on('class_proposals')->onDelete('cascade');
          // Refrence back to original if editing
          $table->integer('level_id')->unsigned()->nullable();
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
        Schema::drop('level_proposals');
    }
}
