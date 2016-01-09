<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_schools', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('zip_id')->unsigned()->index();
          $table->foreign('zip_id')->references('id')->on('zips')->onDelete('cascade');
          $table->string('school_name', 50);
          // Refrence back to original if editing
          $table->integer('school_id')->unsigned()->nullable();
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
        Schema::drop('pending_schools');
    }
}
