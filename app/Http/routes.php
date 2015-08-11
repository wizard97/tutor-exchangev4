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

//some static pages
Route::get('home', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);
Route::get('about', ['as' => 'about.index', function() { return View::make('about'); }]);
Route::get('contact', ['as' => 'contact.index', function() { return View::make('contact'); }]);
Route::get('user/feedback', [
    'as' => 'feedback', function() { return View::make('/templates/feedback'); }]);

//aarons new beta class search

//search home
Route::get('search/index', [
    'as' => 'search.index', 'uses' => 'Search\SearchHomeController@index'
]);
Route::get('search/showtutorprofile/{id}', [
    'as' => 'search.showtutorprofile',
    'middleware' => 'auth',
    'uses' => 'Search\SearchHomeController@showtutorprofile'
]);
Route::get('search/tutorprofileinfo/getclassesbyschool', [
    'as' => 'search.tutorclasses',
    'middleware' => 'auth',
    'uses' => 'Search\SearchHomeController@ajaxtutorclasses'
]);


//school tutoring
Route::get('search/school/index', [
    'as' => 'school.index', 'uses' => 'Search\School\SchoolSearchHomeController@searchform'
]);
Route::post('search/school/submitsearch', [
    'as' => 'school.submitsearch', 'uses' => 'Search\School\SchoolSearchHomeController@searchformsubmit'
]);

//hs tutoring
Route::get('search/school/hsorabove/classes', [
    'as' => 'hs.classes', 'uses' => 'Search\School\HsSearchController@classes'
]);
Route::post('search/school/hsorabove/submitclasses', [
    'as' => 'hs.submitclasses', 'uses' => 'Search\School\HsSearchController@submit_classes'
]);
Route::get('search/school/hsorabove/showresults', [
    'as' => 'hs.showresults', 'uses' => 'Search\School\HsSearchController@run_hs_search'
]);
//school search related routes
Route::get('search/school/hsorabove/myschool', [
    'as' => 'hs.index', 'uses' => 'Search\School\HsSearchController@index'
]);
Route::post('search/school/hsorabove/submitschool', [
    'as' => 'hs.submitschool', 'uses' => 'Search\School\HsSearchController@submit_school'
]);
Route::get('search/school/hsorabove/find/remote/{query}', [
    'as' => 'hs.query', 'uses' => 'Search\School\HsSearchController@query'
]);
Route::get('search/school/hsorabove/find/prefetch', [
    'as' => 'hs.prefetch', 'uses' => 'Search\School\HsSearchController@prefetch'
]);


/* deprecated 8/5/15
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
*/


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
Route::get('account/tutoring/runlisting', [
    'as' => 'tutoring.runlisting', 'uses' => 'Account\TutorController@runlisting'
]);
Route::post('account/tutoring/runlisting', [
    'as' => 'tutoring.submitlisting', 'uses' => 'Account\TutorController@submitlisting'
]);
Route::get('account/tutoring/pauselisting', [
    'as' => 'tutoring.pauselisting', 'uses' => 'Account\TutorController@pauselisting'
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
/* Deprecated after implimented google geocoding api
Route::post('account/settings/editzip', [
    'as' => 'accountsettings.editzip', 'uses' => 'Account\SettingsController@editzip'
]);
*/
Route::post('account/settings/editaccounttype', [
    'as' => 'accountsettings.editaccounttype', 'uses' => 'Account\SettingsController@editaccounttype'
]);
Route::post('account/settings/editpassword', [
    'as' => 'accountsettings.editpassword', 'uses' => 'Account\SettingsController@editpassword'
]);

//user dashboard
Route::get('account/myaccount/index', [
    'as' => 'myaccount.dashboard', 'uses' => 'Account\MyAccountController@index'
]);
//submit review
Route::post('account/myaccount/posttutorreview', [
    'as' => 'myaccount.posttutorreview', 'uses' => 'Account\MyAccountController@posttutorreview'
]);
//ajax methods
Route::post('account/myaccount/sendmessage', [
    'as' => 'myaccount.sendmessage',
     'middleware' => 'auth',
     'uses' => 'Account\MyAccountController@sendmessage'
]);
Route::post('account/myaccount/savetutor', [
    'as' => 'myaccount.ajaxsavetutor',
     'middleware' => 'auth',
     'uses' => 'Account\MyAccountController@ajaxsavetutor'
]);
Route::get('account/myaccount/contacttutor', [
    'as' => 'myaccount.ajaxcontacttutor',
     'middleware' => 'auth',
     'uses' => 'Account\MyAccountController@ajaxcontactjson'
]);

Route::get('account/myaccount/savedtutors', [
    'as' => 'myaccount.ajaxsavedtutors', 'uses' => 'Account\MyAccountController@ajaxsavedtutors'
]);
Route::get('account/myaccount/tutorcontacts', [
    'as' => 'myaccount.ajaxtutorcontacts', 'uses' => 'Account\MyAccountController@ajaxtutorcontacts'
]);
Route::get('account/myaccount/tutorreviews', [
    'as' => 'myaccount.ajaxtutorreviews', 'uses' => 'Account\MyAccountController@ajaxtutorreviews'
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
Route::get('auth/login', [
    'as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('auth/login', [
    'as' => 'auth.postlogin', 'uses' => 'Auth\AuthController@postLogin'
]);
Route::get('auth/logout', [
    'as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout'
]);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@store');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
