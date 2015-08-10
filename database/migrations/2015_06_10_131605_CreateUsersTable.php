<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('fname', 30);
            $table->string('lname', 30);
            $table->integer('account_type');
            $table->float('lat');
            $table->float('lon');
            $table->string('email', 64)->unique();
            $table->boolean('user_active')->default(0);
            $table->string('address', 128);
            $table->integer('zip_id')->unsigned();
            $table->foreign('zip_id')->references('id')->on('zips')->onDelete('cascade');
            $table->boolean('has_picture')->default(0);
            $table->string('password', 255);
            $table->string('remember_token')->nullable();
            $table->string('activation_hash', 40)->nullable();
            $table->timestamp('last_login')->nullable();
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
        Schema::drop('users');
    }
}
