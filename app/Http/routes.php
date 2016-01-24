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
Route::get('mess', ['as' => 'messenger.index', function() { return View::make('account.messages.test'); }]);

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

    Route::get('getclassesbyschool', [
        'as' => 'search.tutorclasses', 'uses' => 'Search\SearchHomeController@ajaxtutorclasses'
    ]);
    Route::get('{id}', [
        'as' => 'search.showtutorprofile', 'uses' => 'Search\SearchHomeController@showtutorprofile'
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
Route::group(['prefix' => 'account', 'middleware' => 'auth', 'namespace' => 'Account'], function() {

  // Messaging
  Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages.index', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
  });

  // Myaccount
  Route::group(['prefix' => 'myaccount'], function() {
    //user dashboard
    Route::get('index', [
        'as' => 'myaccount.dashboard', 'uses' => 'MyAccountController@index'
    ]);
    //submit review
    Route::post('posttutorreview', [
        'as' => 'myaccount.posttutorreview', 'uses' => 'MyAccountController@posttutorreview'
    ]);
    //ajax methods
    Route::post('sendmessage', [
        'as' => 'myaccount.sendmessage', 'uses' => 'MyAccountController@sendmessage'
    ]);
    Route::post('savetutor', [
        'as' => 'myaccount.ajaxsavetutor', 'uses' => 'MyAccountController@ajaxsavetutor'
    ]);
    Route::get('contacttutor', [
        'as' => 'myaccount.ajaxcontacttutor', 'uses' => 'MyAccountController@ajaxcontactjson'
    ]);
    Route::get('savedtutors', [
        'as' => 'myaccount.ajaxsavedtutors', 'uses' => 'MyAccountController@ajaxsavedtutors'
    ]);
    Route::get('tutorcontacts', [
        'as' => 'myaccount.ajaxtutorcontacts', 'uses' => 'MyAccountController@ajaxtutorcontacts'
    ]);
    Route::get('tutorreviews', [
        'as' => 'myaccount.ajaxtutorreviews', 'uses' => 'MyAccountController@ajaxtutorreviews'
    ]);

  });

  // Settings
  Route::group(['prefix' => 'settings'], function() {
    Route::get('index', [
        'as' => 'accountsettings.index', 'uses' => 'SettingsController@index'
    ]);
    Route::post('editname', [
        'as' => 'accountsettings.editname', 'uses' => 'SettingsController@editname'
    ]);
    Route::post('editemail', [
        'as' => 'accountsettings.editemail', 'uses' => 'SettingsController@editemail'
    ]);
    Route::post('editaddress', [
        'as' => 'accountsettings.editaddress', 'uses' => 'SettingsController@editaddress'
    ]);
    Route::post('editaccounttype', [
        'as' => 'accountsettings.editaccounttype', 'uses' => 'SettingsController@editaccounttype'
    ]);
    Route::post('editpassword', [
        'as' => 'accountsettings.editpassword', 'uses' => 'SettingsController@editpassword'
    ]);
  });

  //Tutoring
  Route::group(['prefix' => 'tutoring'], function() {

    Route::get('index', [
        'as' => 'tutoring.dashboard', 'uses' => 'TutorController@getindex'
    ]);
    Route::get('info', [
        'as' => 'tutoring.info', 'uses' => 'TutorController@geteditinfo'
    ]);
    Route::post('editinfo', [
        'as' => 'tutoring.editinfo', 'uses' => 'TutorController@posteditinfo'
    ]);
    Route::get('classes', [
        'as' => 'tutoring.classes', 'uses' => 'TutorController@geteditclasses'
    ]);
    Route::post('editclasses', [
        'as' => 'tutoring.editclasses', 'uses' => 'TutorController@posteditclasses'
    ]);
    Route::get('myprofile', [
        'as' => 'tutoring.myprofile', 'uses' => 'TutorController@getmyprofile'
    ]);
    Route::get('runlisting', [
        'as' => 'tutoring.runlisting', 'uses' => 'TutorController@runlisting'
    ]);
    Route::get('settings', [
        'as' => 'tutoring.settings', 'uses' => 'TutorController@getsettings'
    ]);
    Route::post('runlisting', [
        'as' => 'tutoring.submitlisting', 'uses' => 'TutorController@submitlisting'
    ]);
    Route::get('pauselisting', [
        'as' => 'tutoring.pauselisting', 'uses' => 'TutorController@pauselisting'
    ]);
    Route::get('schedule', [
        'as' => 'tutoring.schedule', 'uses' => 'TutorController@geteditschedule'
    ]);
    Route::post('editschedule', [
        'as' => 'tutoring.editschedule', 'uses' => 'TutorController@posteditschedule'
    ]);
    Route::get('music', [
        'as' => 'tutoring.music', 'uses' => 'TutorController@getmusic'
    ]);
    //add school
    Route::post('addschool', [
        'as' => 'tutoring.addschool', 'uses' => 'TutorController@addschool'
    ]);
    //remove school
    Route::post('removeschool', [
        'as' => 'tutoring.removeschool', 'uses' => 'TutorController@removeschool'
    ]);

    //ajax
    Route::get('ajaxgetschools', [
        'as' => 'tutoring.ajaxgetschools', 'uses' => 'TutorController@ajaxgetschools'
    ]);
    //get classes for school
    Route::get('ajaxgetschoolclasses', [
        'as' => 'tutoring.ajaxgetschoolclasses', 'uses' => 'TutorController@ajaxgetschoolclasses'
    ]);
    //get tutor classes for school
    Route::get('ajaxgettutorschoolclasses', [
        'as' => 'tutoring.ajaxgettutorschoolclasses', 'uses' => 'TutorController@ajaxgettutorschoolclasses'
    ]);
    Route::post('ajaxstartstopmusic', [
        'as' => 'tutoring.ajaxstartstopmusic', 'uses' => 'TutorController@ajaxstartstopmusic'
    ]);
    Route::post('ajaxremovemusic', [
        'as' => 'tutoring.ajaxremovemusic', 'uses' => 'TutorController@ajaxremovemusic'
    ]);
    Route::post('addmusic', [
        'as' => 'tutoring.addmusic', 'uses' => 'TutorController@addmusic'
    ]);
    Route::get('ajaxgettutormiddleclasses', [
        'as' => 'tutoring.ajaxgettutormiddleclasses', 'uses' => 'TutorController@ajaxgettutormiddleclasses'
    ]);
    Route::post('editmiddleclasses', [
        'as' => 'tutoring.editmiddleclasses', 'uses' => 'TutorController@posteditmiddleclasses'
    ]);
    Route::get('ajaxgetmiddleclasses', [
        'as' => 'tutoring.ajaxgetmiddleclasses', 'uses' => 'TutorController@ajaxgetmiddleclasses'
    ]);
    Route::get('submitclass', [
        'as' => 'tutoring.submitclass',
        'uses' => 'TutorController@getsubmitclass'
    ]);
    Route::get('submitschool', [
      'as' => 'tutoring.submitschool', 'uses' => 'TutorController@getsubmitschool'
    ]);
    Route::post('submitschoolproposal', [
      'as' => 'tutoring.submitschoolproposal', 'uses' => 'TutorController@postsubmitschool'
    ]);
    Route::get('submitsubject', [
        'as' => 'tutoring.submitsubject', 'uses' => 'TutorController@getsubmitsubject'
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
