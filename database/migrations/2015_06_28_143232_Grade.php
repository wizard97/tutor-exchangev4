<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Grade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
          $table->increments('id');
          $table->string('grade_name', 30);
        });

        //insert 9th-12th
        for ($i = 9; $i <=12; $i++)
        {
          DB::table('grades')->insert(
            array(
              'id' => $i,
              'grade_name' => $i.'th',
            )
          );
        }

        DB::table('grades')->insert(
          array(
            'grade_name' => 'High School Graduate'
          )
        );

      DB::table('grades')->insert(
        array(
          'grade_name' => 'College'
        )
      );

      DB::table('grades')->insert(
        array(
          'grade_name' => 'College Graduate'
        )
      );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grades', function (Blueprint $table) {
            //
        });
    }
}
