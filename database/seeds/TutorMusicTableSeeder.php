<?php

use Illuminate\Database\Seeder;

use App\Models\Tutor\Tutor;
use App\Models\Music\Music;

class TutorMusicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Tutor::get()->each(function($u) {
        $rand_num = rand(0, 3);
        if (!$rand_num) $u->tutors_music = false;
        else $u->tutors_music = true;
        $u->save();
        for ($i=0; $i < $rand_num; $i++)
        {
          $rand_instrument = Music::orderBy(\DB::raw('RAND()'))->first();
          if (!$u->music()->where('music.id', '=', $rand_instrument->id)->get()->isEmpty()) continue;
          $rand_years = rand(1, 15);
          $upto_years = rand(1, $rand_years);
          $u->music()->attach($rand_instrument->id, ['years_experiance' => $rand_years, 'upto_years' => $upto_years]);
        }
      });
    }
}
