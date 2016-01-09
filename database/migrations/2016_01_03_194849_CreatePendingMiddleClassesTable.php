<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingMiddleClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_middle_classes', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('middle_subject_id')->unsigned()->nullable();
          $table->string('class_name', 50);
          //pending refrence
          $table->integer('pending_middle_subject_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('middle_class_id')->unsigned()->nullable();
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
        Schema::drop('pending_middle_classes');
    }
}
