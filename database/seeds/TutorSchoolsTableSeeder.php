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
      App\Tutor::get()->each(function($tutor) {
        $school_id = \App\School::orderBy(\DB::raw('RAND()'))->take(3)->get()->pluck('id')->toArray();
        if (!$tutor->schools()->whereIn('schools.id', $school_id)->get()->isEmpty()) return;
        $tutor->schools()->attach($school_id);
      });
    }
}
