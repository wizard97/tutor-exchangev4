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
          $table->integer('class_id')->unsigned()->nullable();
          $table->integer('level_num')->unsigned();
          $table->string('level_name', 50);
          //pending refrence to new entry
          $table->integer('class_proposal_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('level_id')->unsigned()->nullable();
          $table->boolean('to_delete')->default(0);

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
        Schema::drop('level_proposals');
    }
}
