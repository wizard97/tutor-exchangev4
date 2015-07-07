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
Route::get('search/index', [
    'as' => 'searchPage', 'uses' => 'SearchController@index'
]);
Route::post('search/index', [
    'as' => 'searchResultsPost', 'uses' => 'SearchController@search'
]);
Route::get('search/showresults', [
    'as' => 'searchResultsGet', 'uses' => 'SearchController@showresults'
]);
Route::get('search/showtutorprofile/{id}', [
    'as' => 'searchTutorProfile', 'uses' => 'SearchController@showtutorprofile'
]);


//tutor
Route::get('account/tutoring/index', [
    'as' => 'tutorDashboard', 'uses' => 'TutorController@getindex'
]);
Route::get('account/tutoring/info', 'TutorController@geteditinfo');
Route::post('account/tutoring/info', 'TutorController@posteditinfo');
Route::get('account/tutoring/classes', 'TutorController@geteditclasses');
Route::post('account/tutoring/classes', 'TutorController@posteditclasses');
Route::get('account/tutoring/myprofile', 'TutorController@getmyprofile');

//settings
Route::get('account/settings/index', [
    'as' => 'accountSettings', 'uses' => 'SettingsController@index'
]);
Route::post('account/settings/editname', [
    'as' => 'editName', 'uses' => 'SettingsController@editname'
]);
Route::post('account/settings/editemail', [
    'as' => 'editEmail', 'uses' => 'SettingsController@editemail'
]);
Route::post('account/settings/editaddress', [
    'as' => 'editAddress', 'uses' => 'SettingsController@editaddress'
]);
Route::post('account/settings/editzip', [
    'as' => 'editZip', 'uses' => 'SettingsController@editzip'
]);
Route::post('account/settings/editaccounttype', [
    'as' => 'editAccountType', 'uses' => 'SettingsController@editaccounttype'
]);
Route::post('account/settings/editpassword', [
    'as' => 'editPassword', 'uses' => 'SettingsController@editpassword'
]);

//images
Route::controller('profileimage', 'ProfileImageController', [
    'getShowFull' => 'profileimage.full.show',
    'getShowSmall' => 'profileimage.small.show',
    'postStore' => 'profileimage.store',
    'getDestroy' => 'profileimage.destroy',
]);

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
