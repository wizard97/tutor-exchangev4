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
        for ($i =0; $i < 5; $i++) {
        $class_id = rand(1, 54);
      $class_levels = App\Level::where('class_id', '=', $class_id);
      $possible_ids = $class_levels->lists('id');
      $u->classes()->whereIn('level_id', $possible_ids)->delete();
      $u->classes()->firstorCreate(['level_id' => $class_levels->get()->pluck('id')->random()]);
    }
    });
  }
}
