<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorMiddleClassesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_middle_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('user_id')->on('tutors')->onDelete('cascade');
            //references level_id
            $table->integer('middle_classes_id')->unsigned();
            $table->foreign('middle_classes_id')->references('id')->on('middle_classes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tutor_middle_classes');
    }
}
