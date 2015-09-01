<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //all schools except LHS
      $classes = App\SchoolClass::where('school_id', '!=', 1)->get();

      $classes->each(function($u) {
        //figure out how many levels for each school
        $level = rand(1, 5);
        for ($i =0; $i < $level; $i++)
        {
          $u->levels()->save(factory('App\Level')->make(['level_num' => $i + 1]));
        }
      });

    }
}
