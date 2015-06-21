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
        'about_me' => $faker->text($maxNbChars = 200),
        'tutor_active' => 1,
        'contact_num' => rand(0, 20),
        'profile_expiration' => $faker->dateTimeThisYear($max = 'now'),


    ];
});
