<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiddleSubjectProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('middle_subject_proposals', function (Blueprint $table) {
          $table->increments('id');
          $table->string('subject_name', 50);
          // Refrence back to original if editing
          $table->integer('middle_subject_id')->unsigned()->nullable();
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
        Schema::drop('middle_subject_proposals');
    }
}
