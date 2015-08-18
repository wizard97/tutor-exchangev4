<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiddleClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('middle_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('middle_subject_id')->unsigned();
            $table->foreign('middle_subject_id')->references('id')->on('middle_subjects')->onDelete('cascade');
            $table->string('class_name', 50);
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
        Schema::drop('middle_classes');
    }
}
