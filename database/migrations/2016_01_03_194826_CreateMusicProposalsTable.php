<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_proposals', function (Blueprint $table) {
          $table->increments('id');
          $table->string('music_name', 50);
          // Refrence back to original if editing
          $table->integer('music_id')->unsigned()->nullable();
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
        Schema::drop('music_proposals');
    }
}
