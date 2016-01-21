<?php

use App\Models\User\User;
use App\Models\Tutor\Tutor;
use App\Models\Zip\Zip;
use App\Models\School\School;
use App\Models\Review\Review;
use App\Models\SchoolClass\SchoolClass;
use App\Models\Level\Level;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function ($faker) {
  do
  {
  $zip = Zip::where('zip_code', '<=', substr($faker->postcode, 0, 5))->orderBy(\DB::raw('RAND()'))->first();
} while(is_null($zip));
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'lat' => $zip->lat,
        'lon' => $zip->lon,
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'zip_id' => $zip->id,
        'password' => str_random(10),
        'remember_token' => str_random(10),
        'user_active' => 1,
        'account_type' => rand(1, 3),


    ];
});

$factory->define(School::class, function ($faker) {
  //make some random zips
  $zip = null;
  do
  {
  $zip = Zip::where('zip_code', '<=', substr($faker->postcode, 0, 5))->orderBy(\DB::raw('RAND()'))->first();
} while(is_null($zip));
    return [
        'zip_id' => $zip->id,
        'school_name' => $faker->company.' High School',
    ];
});



$factory->define(Tutor::class, function ($faker) {
    $rands = [
        'age' => rand(13, 50),
        'grade' => rand(9, 15),
        'rate' => rand(10, 80),
        'about_me' => $faker->text($maxNbChars = 500),
        'tutor_active' => 1,
        'contact_num' => rand(0, 20),
        'profile_expiration' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = '+6 months'),
        //classes
        'highest_math' => $faker->text($maxNbChars = 50),
        'highest_science' => $faker->text($maxNbChars = 50),
        'highest_socialstudies' => $faker->text($maxNbChars = 50),
        'highest_english' => $faker->text($maxNbChars = 50),
        'highest_lang' => $faker->text($maxNbChars = 50),
    ];
    $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];
    foreach ($days as $day)
    {
      for($i = 0; $i < 4; $i++)
      {
        $times[$i] = $faker->time($format = 'H:i');
      }
      //sort high to low
      usort($times, 'time_sort');

      $rands[$day.'2_end'] = $times[0];
      $rands[$day.'2_start'] = $times[1];
      $rands[$day.'1_end'] = $times[2];
      $rands[$day.'1_start'] = $times[3];
    }
    return $rands;
});

function time_sort($a, $b)
{
  if(strtotime($a) > strtotime($b)) return -1;
  else return 1;
}

$factory->define(Review::class, function ($faker) {
    $stud_or_par = rand(0, 1);
    if ($stud_or_par) $reviewer = 'Student';
    else $reviewer = 'Parent';
    return [
        'reviewer_id' => rand(1, 50),
        'rating' => rand(1, 5),
        'title' => $faker->text($maxNbChars = 100),
        'message' => $faker->paragraph($nbSentences = 7) ,
        'anonymous' => rand(0, 1),
        'reviewer' => $reviewer,
    ];
});

$factory->define(SchoolClass::class, function ($faker) {

    return [
        'class_name' => $faker->catchPhrase
    ];
});

$factory->define(Level::class, function ($faker) {
  //some random subjects
  $levels = ['Level 2', 'Level 1', 'Honors', 'AP', 'AP II', 'B Level', 'A Level', 'Accelerated', 'IB', 'IB II'];

  $rand_level = $levels[rand(0, count($levels)-1)];
    return [
        'level_name' => ucfirst($faker->word)
    ];
});
