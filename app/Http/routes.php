<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
return redirect('home');
});

Route::get('home', 'HomeController@index');
Route::get('about', function() { return View::make('about'); });
Route::get('contact', function() { return View::make('contact'); });

//search
Route::get('search/index', 'SearchController@index');
Route::post('search/index', 'SearchController@search');
Route::get('search/showresults', 'SearchController@showresults');
Route::get('search/showtutorprofile/{id}', 'SearchController@showtutorprofile');

//tutor
Route::get('tutor/index', 'TutorController@getindex');
Route::get('tutor/info', 'TutorController@geteditinfo');
Route::get('tutor/classes', 'TutorController@geteditclasses');
Route::get('tutor/myprofile', 'TutorController@getmyprofile');


Route::get('auth/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\AuthController@confirm'
]);
Route::get('profile', [
    'middleware' => 'auth',
    'uses' => 'ProfileController@show'
]);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@store');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
