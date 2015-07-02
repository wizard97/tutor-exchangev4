<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->primary();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('tutor_active');
            $table->dateTime('profile_expiration');
            $table->integer('profile_views')->unsigned();
            $table->integer('contact_num')->unsigned();
            $table->integer('age')->unsigned()->nullable();
            $table->integer('grade')->nullable();
            $table->integer('rate')->nullable();
            $table->text('about_me');
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
        Schema::drop('tutors');
    }
}
