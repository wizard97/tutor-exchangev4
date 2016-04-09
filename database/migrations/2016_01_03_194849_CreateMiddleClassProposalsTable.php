<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiddleClassProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('middle_class_proposals', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('middle_subject_id')->unsigned()->nullable();
          $table->string('class_name', 50);
          //pending refrence
          $table->integer('middle_subject_proposal_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('middle_class_id')->unsigned()->nullable();
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
        Schema::drop('middle_class_proposals');
    }
}
