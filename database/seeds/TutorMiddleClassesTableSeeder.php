<?php

use Illuminate\Database\Seeder;

use App\Models\Tutor\Tutor;
use App\Models\MiddleClass\MiddleClass;

class TutorMiddleClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Tutor::get()->each(function($u) {
        //num middle and below classes
        $rand_num = rand(0, 5);
        for ($i=0; $i < $rand_num; $i++)
        {
          $rand_class = MiddleClass::orderBy(\DB::raw('RAND()'))->first();
          if (!$u->middle_classes()->where('middle_classes.id', '=', $rand_class->id)->get()->isEmpty()) continue;
          $u->middle_classes()->attach($rand_class->id);
        }
      });
    }
}
