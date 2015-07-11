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

Route::get('home', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);
Route::get('about', ['as' => 'about.index', function() { return View::make('about'); }]);
Route::get('contact', ['as' => 'contact.index', function() { return View::make('contact'); }]);


//search
Route::get('search/index', [
    'as' => 'search.index', 'uses' => 'SearchController@index'
]);
Route::post('search/search', [
    'as' => 'search.search', 'uses' => 'SearchController@search'
]);
Route::get('search/showresults', [
    'as' => 'search.showresults', 'uses' => 'SearchController@showresults'
]);
Route::get('search/showtutorprofile/{id}', [
    'as' => 'search.showtutorprofile',
    'middleware' => 'auth',
    'uses' => 'SearchController@showtutorprofile'
]);
Route::post('search/contacttutor', [
    'as' => 'search.ajaxcontacttutor',
     'middleware' => 'auth',
     'uses' => 'SearchController@ajaxcontactjson'
]);
Route::post('search/sendmessage', [
    'as' => 'search.sendmessage',
     'middleware' => 'auth',
     'uses' => 'SearchController@sendmessage'
]);

//tutor
Route::get('account/tutoring/index', [
    'as' => 'tutoring.dashboard', 'uses' => 'Account\TutorController@getindex'
]);
Route::get('account/tutoring/info', [
    'as' => 'tutoring.info', 'uses' => 'Account\TutorController@geteditinfo'
]);
Route::post('account/tutoring/editinfo', [
    'as' => 'tutoring.editinfo', 'uses' => 'Account\TutorController@posteditinfo'
]);
Route::get('account/tutoring/classes', [
    'as' => 'tutoring.classes', 'uses' => 'Account\TutorController@geteditclasses'
]);
Route::post('account/tutoring/classes', [
    'as' => 'tutoring.editclasses', 'uses' => 'Account\TutorController@posteditclasses'
]);
Route::get('account/tutoring/myprofile', [
    'as' => 'tutoring.myprofile', 'uses' => 'Account\TutorController@getmyprofile'
]);

//settings
Route::get('account/settings/index', [
    'as' => 'accountsettings.index', 'uses' => 'Account\SettingsController@index'
]);
Route::post('account/settings/editname', [
    'as' => 'accountsettings.editname', 'uses' => 'Account\SettingsController@editname'
]);
Route::post('account/settings/editemail', [
    'as' => 'accountsettings.editemail', 'uses' => 'Account\SettingsController@editemail'
]);
Route::post('account/settings/editaddress', [
    'as' => 'accountsettings.editaddress', 'uses' => 'Account\SettingsController@editaddress'
]);
Route::post('account/settings/editzip', [
    'as' => 'accountsettings.editzip', 'uses' => 'Account\SettingsController@editzip'
]);
Route::post('account/settings/editaccounttype', [
    'as' => 'accountsettings.editaccounttype', 'uses' => 'Account\SettingsController@editaccounttype'
]);
Route::post('account/settings/editpassword', [
    'as' => 'accountsettings.editpassword', 'uses' => 'Account\SettingsController@editpassword'
]);

//images
Route::controller('profileimage', 'Account\ProfileImageController', [
    'getShowFull' => 'profileimage.showfull',
    'getShowSmall' => 'profileimage.showsmall',
    'postStore' => 'profileimage.store',
    'getDestroy' => 'profileimage.destroy',
]);

Route::get('auth/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\AuthController@confirm'
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
