<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_proposals', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('zip_id')->unsigned()->index();
          $table->foreign('zip_id')->references('id')->on('zips')->onDelete('cascade');
          $table->string('school_name', 50);
          $table->string('address', 128);
          $table->float('lat');
          $table->float('lon');
          // Refrence back to original if editing
          $table->integer('school_id')->unsigned()->nullable();
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
        Schema::drop('school_proposals');
    }
}
