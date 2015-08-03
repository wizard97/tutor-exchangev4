<?php

use Illuminate\Database\Seeder;

class TutorLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      App\Tutor::get()->each(function($u) {

        $u->schools->each(function ($school) use ($u)
        {
          for ($i=0; $i < 10; $i++)
          {
            $rand_class = $school->classes()->orderBy(\DB::raw('RAND()'))->first();
            if (!$u->levels()->where('class_id', '=', $rand_class->id)->get()->isEmpty()) return;
            $u->levels()->attach($rand_class->levels()->get()->random()->id);
          }
        });

    });
  }
}
