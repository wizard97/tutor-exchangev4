<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     * Pivot Table
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_schools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('user_id')->on('tutors')->onDelete('cascade');
            $table->integer('school_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tutor_schools');
    }
}
