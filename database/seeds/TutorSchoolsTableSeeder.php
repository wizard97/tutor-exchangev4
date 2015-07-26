<?php

use Illuminate\Database\Seeder;

class TutorSchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for ($i=0; $i < 150; $i++)
      {
      $tutor = \App\Tutor::orderBy(\DB::raw('RAND()'))->first();
      $school_id = \App\School::orderBy(\DB::raw('RAND()'))->take(3)->get()->pluck('id')->toArray();
      $tutor->schools()->attach($school_id);
      }
    }
}
