<?php

use Illuminate\Database\Seeder;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //all schools except LHS
      $schools = App\School::where('id', '!=', 1)->get();

      $schools->each(function($u) {
        //figure out how many classes for each school
        $classes = rand(1, 30);
        for ($i =0; $i < $classes; $i++)
        {
          $u->subjects()->orderBy(DB::raw('RAND()'))->first()->classes()->save(factory('App\SchoolClass')->make());
        }
      });

    }
}
