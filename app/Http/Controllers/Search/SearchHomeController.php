<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tutor\Tutor;

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
    $tutor = Tutor::findOrFail($id);
    //get levels and join on class info, get all the subjects
    $subjects = $tutor->levels()
    ->join('classes', 'levels.class_id', '=', 'classes.id')
    ->join('school_subjects', 'classes.subject_id', '=', 'school_subjects.id')
    ->groupBy('subject_id')
    ->select('school_subjects.school_id', 'classes.subject_id', 'subject_name', \DB::raw('count(*) AS num_classes'))
    ->get()
    ->groupBy('school_id');
    //get tutor schools
    $schools = $tutor->schools()
    ->leftJoin('school_subjects', 'school_subjects.school_id', '=', 'schools.id')
    ->leftJoin('classes', 'classes.subject_id', '=', 'school_subjects.id')
    ->leftjoin('levels', 'levels.class_id', '=', 'classes.id')
    ->join('tutor_levels', 'tutor_levels.level_id', '=', 'levels.id')
    ->where('tutor_levels.user_id', $tutor->user_id)
    ->groupBy('schools.id')
    ->orderBy('num_classes', 'desc')
    ->select('schools.school_name', 'schools.id', \DB::raw('COUNT(*) AS num_classes'))
    ->get();
    $reviews = $tutor->reviews()->join('users', 'users.id', '=', 'reviews.tutor_id')
    ->select('reviews.*', 'users.fname', 'users.lname')
    ->orderBy('reviews.created_at', 'desc')
    ->get();
    $tutor = Tutor::get_tutor_profile($id);
    $saved_tutors = \Auth::user()->saved_tutors()->get()->pluck('tutor_id')->toArray();
    return view('search/showtutorprofile')->with('tutor', $tutor)->with('subjects', $subjects)->with('saved_tutors', $saved_tutors)->with('schools', $schools)
    ->with('reviews', $reviews);
  }

  //ajax stuff
  public function ajaxtutorclasses(Request $request)
  {
    $this->validate($request, [
      'school_id' => 'required|exists:schools,id',
      'tutor_id' => 'required|exists:tutors,user_id',
    ]);
    $tutor = Tutor::findOrFail($request->get('tutor_id'));
    $tutor_classes = $tutor->levels()
    ->join('classes', 'classes.id', '=', 'levels.class_id')
    ->join('school_subjects', 'school_subjects.id', '=', 'classes.subject_id')
    ->where('school_subjects.school_id', $request->get('school_id'))
    ->select('classes.id', 'levels.level_name', 'classes.class_name', 'school_subjects.subject_name')
    ->get();

    return response()->json(['data' => $tutor_classes]);

  }

}
