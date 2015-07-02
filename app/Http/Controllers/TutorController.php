<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TutorController extends Controller
{
  private $id;
  public function __construct()
  {
      $this->middleware('\App\Http\Middleware\AuthenticateTutors');
      $this->id = \Auth::user()->id;
  }

  public function getindex()
  {
    return view('tutor/index');
  }

  public function geteditclasses()
  {
    $id = 32;
    $classes = \App\SchoolClass::with('class_levels')->orderBy('class_order', 'asc')
    ->get()
    ->groupBy('class_type');

    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');

    $grades = \App\Grade::all();
    //get basic tutor info
    $tutor = \App\Tutor::get_tutor_profile($id);


    return view('tutor/editclasses')
    ->with('tutor', $tutor)
    ->with('subjects', $subjects)
    ->with('classes', $classes);
  }

  public function posteditclasses()
  {

  }

  public function geteditinfo()
  {
    $id = 32;
    $tutor = \App\Tutor::get_tutor_profile($id);

    $grades = \App\Grade::all();
    return view('tutor/editinfo')
    ->with('tutor', $tutor)
    ->with('grades', $grades);
  }

  public function getmyprofile()
  {
    $id = 32;
    //get subjects
    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
    //get basic tutor info
    $tutor = \App\Tutor::get_tutor_profile($id);
    return view('tutor/myprofile')->with('tutor', $tutor)->with('subjects', $subjects);
  }
}
