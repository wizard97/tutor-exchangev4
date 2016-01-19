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
      // Skip over LHS eventually!!!!

      App\Tutor::get()->each(function($u) {

        $u->schools->each(function ($school) use ($u)
        {
          $rand_num = rand(10, 50);
          for ($i=0; $i < $rand_num; $i++)
          {
            $rand_class = $school->classes()->orderBy(\DB::raw('RAND()'))->first();
            if (!$u->levels()->where('class_id', '=', $rand_class->id)->get()->isEmpty()) continue;
            if (!$rand_class->levels()->get()->isEmpty())
            {
              $u->levels()->attach($rand_class->levels()->get()->random()->id);
            }
          }
        });

    });
  }
}
