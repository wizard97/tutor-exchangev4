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
Route::get('test', [
    'as' => 'test', 'uses' => 'Account\ProposalController@index'
]);

//some static pages
Route::get('home', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);
Route::get('about', ['as' => 'about.index', function() { return View::make('about'); }]);
Route::get('contact/index', [
    'as' => 'contact.index', 'uses' => 'ContactController@index'
]);
Route::post('contact/send', [
    'as' => 'contact.send', 'uses' => 'ContactController@send'
]);
Route::get('user/feedback', [
    'as' => 'feedback', function() { return View::make('/templates/feedback'); }]);

//Anything search related
Route::group(['prefix' => 'search'], function() {

  // Only members can see these search pages
  Route::group(['prefix' => 'showtutorprofile', 'middleware' => 'auth'], function() {

    Route::get('{id}', [
        'as' => 'search.showtutorprofile', 'uses' => 'Search\SearchHomeController@showtutorprofile'
    ]);
    Route::get('getclassesbyschool', [
        'as' => 'search.tutorclasses', 'uses' => 'Search\SearchHomeController@ajaxtutorclasses'
    ]);
  });

  //search home
  Route::get('index', [
      'as' => 'search.index', 'uses' => 'Search\SearchHomeController@index'
  ]);
  //school tutoring
  Route::get('school/index', [
      'as' => 'school.index', 'uses' => 'Search\School\SchoolSearchHomeController@searchform'
  ]);
  Route::post('school/submitsearch', [
      'as' => 'school.submitsearch', 'uses' => 'Search\School\SchoolSearchHomeController@searchformsubmit'
  ]);

  //hs tutoring
  Route::get('school/hsorabove/classes', [
      'as' => 'hs.classes', 'uses' => 'Search\School\HsSearchController@classes'
  ]);
  Route::post('school/hsorabove/submitclasses', [
      'as' => 'hs.submitclasses', 'uses' => 'Search\School\HsSearchController@submit_classes'
  ]);
  Route::get('school/hsorabove/showresults', [
      'as' => 'hs.showresults', 'uses' => 'Search\School\HsSearchController@run_hs_search'
  ]);
  //school search related routes
  Route::get('school/hsorabove/myschool', [
      'as' => 'hs.index', 'uses' => 'Search\School\HsSearchController@index'
  ]);
  Route::post('school/hsorabove/submitschool', [
      'as' => 'hs.submitschool', 'uses' => 'Search\School\HsSearchController@submit_school'
  ]);
  Route::get('school/hsorabove/find/remote/{query}', [
      'as' => 'hs.query', 'uses' => 'Search\School\HsSearchController@query'
  ]);
  Route::get('school/hsorabove/find/prefetch', [
      'as' => 'hs.prefetch', 'uses' => 'Search\School\HsSearchController@prefetch'
  ]);

  //ms tutoring
  Route::get('school/middleorbelow/classes', [
      'as' => 'middle.classes', 'uses' => 'Search\School\MiddleSearchController@classes'
  ]);
  Route::post('school/middleorbelow/submitclasses', [
      'as' => 'middle.submitclasses', 'uses' => 'Search\School\MiddleSearchController@submit_classes'
  ]);
  Route::get('school/middleorbelow/showresults', [
      'as' => 'middle.showresults', 'uses' => 'Search\School\MiddleSearchController@run_search'
  ]);

  //music
  Route::get('music/index', [
      'as' => 'music.index', 'uses' => 'Search\Music\MusicController@index'
  ]);
  Route::post('music/submitsearch', [
      'as' => 'music.submitsearch', 'uses' => 'Search\Music\MusicController@searchformsubmit'
  ]);
  Route::get('music/showresults', [
      'as' => 'music.showresults', 'uses' => 'Search\Music\MusicController@showresults'
  ]);
});


// Anything that requires an account
Route::group(['prefix' => 'account', 'middleware' => 'auth'], function() {

  // Myaccount
  Route::group(['prefix' => 'myaccount'], function() {
    //user dashboard
    Route::get('index', [
        'as' => 'myaccount.dashboard', 'uses' => 'Account\MyAccountController@index'
    ]);
    //submit review
    Route::post('posttutorreview', [
        'as' => 'myaccount.posttutorreview', 'uses' => 'Account\MyAccountController@posttutorreview'
    ]);
    //ajax methods
    Route::post('sendmessage', [
        'as' => 'myaccount.sendmessage', 'uses' => 'Account\MyAccountController@sendmessage'
    ]);
    Route::post('savetutor', [
        'as' => 'myaccount.ajaxsavetutor', 'uses' => 'Account\MyAccountController@ajaxsavetutor'
    ]);
    Route::get('contacttutor', [
        'as' => 'myaccount.ajaxcontacttutor', 'uses' => 'Account\MyAccountController@ajaxcontactjson'
    ]);
    Route::get('savedtutors', [
        'as' => 'myaccount.ajaxsavedtutors', 'uses' => 'Account\MyAccountController@ajaxsavedtutors'
    ]);
    Route::get('tutorcontacts', [
        'as' => 'myaccount.ajaxtutorcontacts', 'uses' => 'Account\MyAccountController@ajaxtutorcontacts'
    ]);
    Route::get('tutorreviews', [
        'as' => 'myaccount.ajaxtutorreviews', 'uses' => 'Account\MyAccountController@ajaxtutorreviews'
    ]);

  });

  // Settings
  Route::group(['prefix' => 'settings'], function() {
    Route::get('index', [
        'as' => 'accountsettings.index', 'uses' => 'Account\SettingsController@index'
    ]);
    Route::post('editname', [
        'as' => 'accountsettings.editname', 'uses' => 'Account\SettingsController@editname'
    ]);
    Route::post('editemail', [
        'as' => 'accountsettings.editemail', 'uses' => 'Account\SettingsController@editemail'
    ]);
    Route::post('editaddress', [
        'as' => 'accountsettings.editaddress', 'uses' => 'Account\SettingsController@editaddress'
    ]);
    Route::post('editaccounttype', [
        'as' => 'accountsettings.editaccounttype', 'uses' => 'Account\SettingsController@editaccounttype'
    ]);
    Route::post('editpassword', [
        'as' => 'accountsettings.editpassword', 'uses' => 'Account\SettingsController@editpassword'
    ]);
  });

  //Tutoring
  Route::group(['prefix' => 'tutoring'], function() {

    Route::get('index', [
        'as' => 'tutoring.dashboard', 'uses' => 'Account\TutorController@getindex'
    ]);
    Route::get('info', [
        'as' => 'tutoring.info', 'uses' => 'Account\TutorController@geteditinfo'
    ]);
    Route::post('editinfo', [
        'as' => 'tutoring.editinfo', 'uses' => 'Account\TutorController@posteditinfo'
    ]);
    Route::get('classes', [
        'as' => 'tutoring.classes', 'uses' => 'Account\TutorController@geteditclasses'
    ]);
    Route::post('editclasses', [
        'as' => 'tutoring.editclasses', 'uses' => 'Account\TutorController@posteditclasses'
    ]);
    Route::get('myprofile', [
        'as' => 'tutoring.myprofile', 'uses' => 'Account\TutorController@getmyprofile'
    ]);
    Route::get('runlisting', [
        'as' => 'tutoring.runlisting', 'uses' => 'Account\TutorController@runlisting'
    ]);
    Route::get('settings', [
        'as' => 'tutoring.settings', 'uses' => 'Account\TutorController@getsettings'
    ]);
    Route::post('runlisting', [
        'as' => 'tutoring.submitlisting', 'uses' => 'Account\TutorController@submitlisting'
    ]);
    Route::get('pauselisting', [
        'as' => 'tutoring.pauselisting', 'uses' => 'Account\TutorController@pauselisting'
    ]);
    Route::get('schedule', [
        'as' => 'tutoring.schedule', 'uses' => 'Account\TutorController@geteditschedule'
    ]);
    Route::post('editschedule', [
        'as' => 'tutoring.editschedule', 'uses' => 'Account\TutorController@posteditschedule'
    ]);
    Route::get('music', [
        'as' => 'tutoring.music', 'uses' => 'Account\TutorController@getmusic'
    ]);
    //add school
    Route::post('addschool', [
        'as' => 'tutoring.addschool', 'uses' => 'Account\TutorController@addschool'
    ]);
    //remove school
    Route::post('removeschool', [
        'as' => 'tutoring.removeschool', 'uses' => 'Account\TutorController@removeschool'
    ]);

    //ajax
    Route::get('ajaxgetschools', [
        'as' => 'tutoring.ajaxgetschools', 'uses' => 'Account\TutorController@ajaxgetschools'
    ]);
    //get classes for school
    Route::get('ajaxgetschoolclasses', [
        'as' => 'tutoring.ajaxgetschoolclasses', 'uses' => 'Account\TutorController@ajaxgetschoolclasses'
    ]);
    //get tutor classes for school
    Route::get('ajaxgettutorschoolclasses', [
        'as' => 'tutoring.ajaxgettutorschoolclasses', 'uses' => 'Account\TutorController@ajaxgettutorschoolclasses'
    ]);
    Route::post('ajaxstartstopmusic', [
        'as' => 'tutoring.ajaxstartstopmusic', 'uses' => 'Account\TutorController@ajaxstartstopmusic'
    ]);
    Route::post('ajaxremovemusic', [
        'as' => 'tutoring.ajaxremovemusic', 'uses' => 'Account\TutorController@ajaxremovemusic'
    ]);
    Route::post('addmusic', [
        'as' => 'tutoring.addmusic', 'uses' => 'Account\TutorController@addmusic'
    ]);
    Route::get('ajaxgettutormiddleclasses', [
        'as' => 'tutoring.ajaxgettutormiddleclasses', 'uses' => 'Account\TutorController@ajaxgettutormiddleclasses'
    ]);
    Route::post('editmiddleclasses', [
        'as' => 'tutoring.editmiddleclasses', 'uses' => 'Account\TutorController@posteditmiddleclasses'
    ]);
    Route::get('ajaxgetmiddleclasses', [
        'as' => 'tutoring.ajaxgetmiddleclasses', 'uses' => 'Account\TutorController@ajaxgetmiddleclasses'
    ]);
    Route::get('settingsplaceholder', [
        'as' => 'tutoring.placeholder'
    ]);
    Route::get('submitclass', [
        'as' => 'tutoring.submitclass',
        'uses' => 'Account\TutorController@getsubmitclass'
    ]);
    Route::get('submitschool', [
      'as' => 'tutoring.submitschool', 'uses' => 'Account\TutorController@getsubmitschool'
    ]);
    Route::get('submitsubject', [
        'as' => 'tutoring.submitsubject', 'uses' => 'Account\TutorController@getsubmitsubject'
    ]);

  });

});

// Authentication routes...
Route::group(['prefix' => 'auth'], function() {

  Route::get('login', [
      'as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin'
  ]);
  Route::post('login', [
      'as' => 'auth.postlogin', 'uses' => 'Auth\AuthController@postLogin'
  ]);
  Route::get('logout', [
      'as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout'
  ]);
  // Registration routes...
  Route::get('register', 'AuthController@getRegister');
  Route::post('register', 'AuthController@store');
  Route::get('verify/{confirmationCode}', [
      'as' => 'confirmation_path',
      'uses' => 'Auth\AuthController@confirm'
  ]);

});

// Password reset link request routes...
Route::group(['prefix' => 'password'], function() {
  Route::get('email', 'Auth\PasswordController@getEmail');
  Route::post('email', 'Auth\PasswordController@postEmail');

  // Password reset routes...
  Route::get('reset/{token}', 'Auth\PasswordController@getReset');
  Route::post('reset', 'Auth\PasswordController@postReset');
});


//images
Route::controller('profileimage', 'Account\ProfileImageController', [
    'getShowFull' => 'profileimage.showfull',
    'getShowSmall' => 'profileimage.showsmall',
    'postStore' => 'profileimage.store',
    'getDestroy' => 'profileimage.destroy',
]);
