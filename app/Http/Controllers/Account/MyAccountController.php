<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MyAccountController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      if (\Auth::check()) {
      $this->id = \Auth::user()->id;
      }
    }

    public function index()
    {
      $user = \App\User::findOrFail($this->id);
      $saved_tutors = $user->saved_tutors()
      ->join('users', 'saved_tutors.tutor_id', '=', 'users.id')
      ->join('tutors', 'saved_tutors.tutor_id', '=', 'tutors.user_id')
      ->leftJoin('reviews', 'saved_tutors.tutor_id', '=', 'reviews.tutor_id')
      ->join('grades', 'tutors.grade', '=', 'grades.id')
      ->select('saved_tutors.created_at AS saved_at', 'users.*', 'saved_tutors.*', 'tutors.*', 'grades.*', \DB::raw('COUNT(reviews.tutor_id) as num_reviews'), \DB::raw('AVG(reviews.rating) as rating'))
      ->groupBy('saved_tutors.tutor_id')->orderBy('saved_at', 'desc')->get();
      return view('/account/myaccount/index')->with('saved_tutors', $saved_tutors);
    }
}
