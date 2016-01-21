<?php

use Illuminate\Database\Seeder;

use App\Models\Tutor\Tutor;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $tutors = Tutor::all();

      $tutors->each(function($u) {
        //figure out how many reviews for each user
        $reviews = rand(0, 5);

        for ($i =0; $i < $reviews; $i++)
        {
          $u->reviews()->save(factory('App\Models\Review\Review')->make());
        }
     });

    }
}
