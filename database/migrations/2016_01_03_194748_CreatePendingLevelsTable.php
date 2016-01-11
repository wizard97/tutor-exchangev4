<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_levels', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('class_id')->unsigned()->nullable();
          $table->integer('level_num')->unsigned();
          $table->string('level_name', 50);
          //pending refrence to new entry
          $table->integer('pending_class_id')->unsigned()->nullable();
          // Refrence back to original if editing
          $table->integer('level_id')->unsigned()->nullable();
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
        Schema::drop('pending_levels');
    }
}
