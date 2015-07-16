<?php

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

$factory->define(App\User::class, function ($faker) {
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'password' => str_random(10),
        'remember_token' => str_random(10),
        'user_active' => 1,
        'account_type' => rand(1, 3),


    ];
});




$factory->define(App\Tutor::class, function ($faker) {
    return [
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
        'highest_french' => $faker->text($maxNbChars = 50),
        'highest_spanish' => $faker->text($maxNbChars = 50),
        'highest_german' => $faker->text($maxNbChars = 50),
        'highest_italian' => $faker->text($maxNbChars = 50),
        'highest_mandarin' => $faker->text($maxNbChars = 50),


    ];
});


$factory->define(App\Review::class, function ($faker) {
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
