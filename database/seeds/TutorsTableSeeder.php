<?php

use Illuminate\Database\Seeder;

use App\Models\User\User;

class TutorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
       $tutors = User::where('account_type', '>', 1)->get();

       $tutors->each(function($u) {
         if (is_null($u->tutor)) $u->tutor()->save(factory('App\Models\Tutor\Tutor')->make());
        });
      }

}
