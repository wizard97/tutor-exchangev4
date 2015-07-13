<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reviewer_id')->unsigned();
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('tutor_id')->unsigned();
            $table->foreign('tutor_id')->references('user_id')->on('tutors')->onDelete('cascade');
            $table->integer('rating')->unsigned();
            $table->string('title', 100);
            $table->text('message');
            $table->boolean('anonymous')->default(0);
            $table->string('reviewer', 20)->index();
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
        Schema::drop('reviews');
    }
}
