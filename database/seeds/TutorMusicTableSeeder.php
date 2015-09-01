<?php

use Illuminate\Database\Seeder;

class TutorMusicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      App\Tutor::get()->each(function($u) {
        $rand_num = rand(0, 3);
        for ($i=0; $i < $rand_num; $i++)
        {
          $rand_instrument = \App\Music::orderBy(\DB::raw('RAND()'))->first();
          if (!$u->music()->where('music.id', '=', $rand_instrument->id)->get()->isEmpty()) continue;
          $rand_years = rand(1, 15);
          $upto_years = rand(1, $rand_years);
          $u->music()->attach($rand_instrument->id, ['years_experiance' => $rand_years, 'upto_years' => $upto_years]);
        }
      });
    }
}
