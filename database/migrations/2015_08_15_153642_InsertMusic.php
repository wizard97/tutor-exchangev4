<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Music\Music;

class InsertMusic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $instruments = ['Piano', 'Guitar', 'Violin', 'Mandolin', 'Clarinet', 'Flute', 'Voice', 'Drums', 'Cello', 'Saxophone',
      'Trumpet', 'French Horn', 'Keyboard', 'Guitar', 'Viola', 'Bass Guitar', 'Bass', 'Piccolo',
       'Oboe', 'Euphonium', 'Tuba', 'Baritone', 'Bassoon', 'Timpani'];
       sort($instruments);
       $level_names = ['Beginner', 'Intermediate', 'Advanced'];
       $years_experience = ['3', '6', '7'];

       foreach ($instruments as $instrument)
       {
         $music = Music::create(['music_name' => $instrument]);
       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      \DB::table('tutor_music')->delete();
      \DB::table('music')->delete();
    }
}
