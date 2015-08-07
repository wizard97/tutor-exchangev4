<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchHomeController extends Controller
{
  //choose what type of tutoring
  public function index()
  {
    return view('search/index');
  }

  /**
   * Show tutor profile
   *
   * @param  int  $id
   * @return Response
   */
  public function showtutorprofile($id)
  {
    //get subjects
    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
    //get basic tutor info
    $tutor = \App\Tutor::get_tutor_profile($id);
    $saved_tutors = \Auth::user()->saved_tutors()->get()->pluck('tutor_id')->toArray();
    return view('search/showtutorprofile')->with('tutor', $tutor)->with('subjects', $subjects)->with('saved_tutors', $saved_tutors);
  }

  }
