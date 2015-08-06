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
      //get saves tutors
      $saved_tutors = $user->saved_tutors()
      ->join('users', 'tutors.user_id', '=', 'users.id')
      ->leftJoin('reviews', 'tutors.user_id', '=', 'reviews.tutor_id')
      ->leftJoin('grades', 'tutors.grade', '=', 'grades.id')
      ->select('users.*', 'tutors.*', 'grades.*', \DB::raw('COUNT(reviews.tutor_id) as num_reviews'), \DB::raw('AVG(reviews.rating) as rating'))
      ->groupBy('tutors.user_id')->orderBy('pivot_created_at', 'desc')->get();
      //get reviews you left
      $reviews = $user->reviews()->join('users', 'reviews.tutor_id', '=', 'users.id')->select('reviews.*', 'users.fname', 'users.lname')->get();

      //get tutor contacts
      $contacts = $user->tutor_contacts()->join('users', 'tutor_contacts.tutor_id', '=', 'users.id')->select('tutor_contacts.*', 'users.fname', 'users.lname')->get();

      //bind data to be printed as json
      \JavaScript::put([
      'saved_tutors' => $saved_tutors,
      'reviews' => $reviews,
      'contacts' => $contacts,
      ]);

      return view('/account/myaccount/index')->with('saved_tutors', $saved_tutors);
    }
}
