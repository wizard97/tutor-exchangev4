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
            $table->timestamp('profile_expiration')->nullable();
            $table->integer('profile_views')->unsigned();
            $table->integer('contact_num')->unsigned();
            $table->integer('age')->unsigned()->nullable();
            $table->integer('grade')->nullable();
            $table->integer('rate')->nullable();
            $table->text('about_me');
            $table->string('highest_math', 50);
            $table->string('highest_science', 50);
            $table->string('highest_socialstudies', 50);
            $table->string('highest_english', 50);
            $table->string('highest_french', 50);
            $table->string('highest_spanish', 50);
            $table->string('highest_german', 50);
            $table->string('highest_italian', 50);
            $table->string('highest_mandarin', 50);
            $table->time('mon1_start')->nullable();
            $table->time('mon1_end')->nullable();
            $table->time('mon2_start')->nullable();
            $table->time('mon2_end')->nullable();
            $table->time('tues1_start')->nullable();
            $table->time('tues1_end')->nullable();
            $table->time('tues2_start')->nullable();
            $table->time('tues2_end')->nullable();
            $table->time('wed1_start')->nullable();
            $table->time('wed1_end')->nullable();
            $table->time('wed2_start')->nullable();
            $table->time('wed2_end')->nullable();
            $table->time('thurs1_start')->nullable();
            $table->time('thurs1_end')->nullable();
            $table->time('thurs2_start')->nullable();
            $table->time('thurs2_end')->nullable();
            $table->time('fri1_start')->nullable();
            $table->time('fri1_end')->nullable();
            $table->time('fri2_start')->nullable();
            $table->time('fri2_end')->nullable();
            $table->time('sat1_start')->nullable();
            $table->time('sat1_end')->nullable();
            $table->time('sat2_start')->nullable();
            $table->time('sat2_end')->nullable();
            $table->time('sun1_start')->nullable();
            $table->time('sun1_end')->nullable();
            $table->time('sun2_start')->nullable();
            $table->time('sun2_end')->nullable();
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
