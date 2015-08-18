<?php

use Illuminate\Database\Seeder;

class TutorMiddleClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      App\Tutor::get()->each(function($u) {
        //num middle and below classes
        $rand_num = rand(0, 5);
        for ($i=0; $i < $rand_num; $i++)
        {
          $rand_class = \App\MiddleClass::orderBy(\DB::raw('RAND()'))->first();
          if (!$u->middle_classes()->where('id', '=', $rand_class->id)->get()->isEmpty()) continue;
          $u->middle_classes()->attach($rand_class->id);
        }
      });
    }
}
