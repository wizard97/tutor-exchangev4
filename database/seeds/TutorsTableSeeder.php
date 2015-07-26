<?php

use Illuminate\Database\Seeder;

class TutorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
       $tutors = App\User::where('account_type', '>', 1)->get();

       $tutors->each(function($u) {
       $u->tutor()->save(factory('App\Tutor')->make());
        });
      }

}
