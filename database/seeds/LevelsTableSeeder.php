<?php

use Illuminate\Database\Seeder;

use App\Models\SchoolSubject\SchoolSubject;
use App\Models\SchoolClass\SchoolClass;

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
      $subs = SchoolSubject::where('school_id', '=', 1)->get()->pluck('id');
      $classes = SchoolClass::whereNotIn('subject_id', $subs)->get();

      $classes->each(function($u) {
        //figure out how many levels for each school
        $level = rand(1, 5);
        for ($i =0; $i < $level; $i++)
        {
          $u->levels()->save(factory('App\Models\Level\Level')->make(['level_num' => $i + 1]));
        }
      });

    }
}
