<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('stats', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('visitors');
          $table->integer('searches');
          $table->integer('tutor_contacts');
      });
      DB::table('stats')->insert(['id' => '1', 'visitors' => 0, 'searches' => 0, 'tutor_contacts' => 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('stats');
    }
}
