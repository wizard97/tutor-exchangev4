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
      ->leftJoin('zips', 'users.zip_id', '=', 'zips.id')
      ->select('users.id', 'fname', 'lname', 'account_type', 'last_login', 'user_active', 'users.created_at', 'last_login', 'tutors.*', 'grades.grade_name', \DB::raw('COUNT(reviews.tutor_id) as num_reviews'), \DB::raw('AVG(reviews.rating) as rating'))
      ->groupBy('tutors.user_id')->orderBy('pivot_created_at', 'desc')->get();

      //get reviews you left
      $reviews = $user->reviews()
      ->join('users', 'reviews.tutor_id', '=', 'users.id')
      ->select('reviews.*', 'users.fname', 'users.lname')
      ->orderBy('reviews.created_at', 'desc')
      ->get();

      //get tutor contacts
      $contacts = $user->tutor_contacts()
      ->join('users', 'tutor_contacts.tutor_id', '=', 'users.id')
      ->select('tutor_contacts.*', 'users.fname', 'users.lname')
      ->orderBy('tutor_contacts.created_at', 'desc')
      ->get();

      //bind data to be printed as json
      //careful not to send any sensitive data!!!!!
      \JavaScript::put([
        'saved_tutors' => $saved_tutors,
        'reviews' => $reviews,
        'contacts' => $contacts,
        ]);

        return view('/account/myaccount/index')->with('saved_tutors', $saved_tutors);
      }

      public function ajaxcontactjson(Request $request)
      {
        $this->validate($request, [
          'userid' => 'required|exists:tutors,user_id'
          ]);

          $tutor = \App\Tutor::get_tutor_profile($request->input('userid'));

          $data['name'] = $tutor->fname.' '.$tutor->lname;
          $data['tutor_profile'] = route('search.showtutorprofile', ['id' => $request->input('userid')]);
          $data['post_url'] = route('myaccount.sendmessage');

          return response()->json($data);
        }


      public function sendmessage(Request $request)
      {
        $this->validate($request, [
          'user_id' => 'required|exists:tutors,user_id',
          'subject' => 'required|string',
          'message' => 'required|string',
        ]);

        $tutor = \App\Tutor::get_tutor_profile($request->input('user_id'));
        $user = \Auth::user();
        //queue only works with arrays
        $inputs = $request->all();
        $data['inputs'] = $inputs;
        $data['tutor'] = $tutor->toArray();
        $data['user'] = $user->toArray();

      \Mail::queue('emails.tutorcontact', $data, function ($message) use($inputs, $tutor, $user){
        $message->from($user->email, "Lexington Tutor Exchange Forwarder");
        $message->to($tutor->email, $tutor->fname.' '.$tutor->lname);
        $message->replyTo($user->email, $user->fname.' '.$user->lname);
        $message->subject($inputs['subject']);
      });

      \Session::flash('feedback_positive', 'Your email to '.$tutor->fname.' '.$tutor->lname.' has been successfully sent!');

      $contact = new \App\TutorContact;
      $contact->user_id = $user->id;
      $contact->tutor_id = $request->input('user_id');
      $contact->message = $request->input('message');
      $contact->subject = $request->input('subject');
      $contact->save();

      return view('templates/feedback');
    }

    public function ajaxsavetutor(Request $request)
    {
      $this->validate($request, [
      'user_id' => 'required|exists:tutors,user_id',
      ]);
      $id = $request->input('user_id');
      $tutor = \App\Tutor::get_tutor_profile($id);


      $search = \Auth::user()->saved_tutors()->find($id);

      if (is_null($search))
      {
        \Auth::user()->saved_tutors()->attach($id);
        \Session::flash('feedback_positive', 'You have successfully added '.$tutor->fname.' '.$tutor->lname.' to your saved tutors.');
        return response()->json([$id => true]);
      }

      else
      {
        \Auth::user()->saved_tutors()->detach($id);
        \Session::flash('feedback_positive', 'You have successfully removed '.$tutor->fname.' '.$tutor->lname.' from your saved tutors.');
        return response()->json([$id => false]);
      }

    }

    public function ajaxsavedtutors(Request $request)
    {
      $saved_tutors = \App\User::findOrFail($this->id)->saved_tutors()
      ->join('users', 'tutors.user_id', '=', 'users.id')
      ->leftJoin('reviews', 'tutors.user_id', '=', 'reviews.tutor_id')
      ->leftJoin('grades', 'tutors.grade', '=', 'grades.id')
      ->leftJoin('zips', 'users.zip_id', '=', 'zips.id')
      ->select('users.id', 'fname', 'lname', 'account_type', 'last_login', 'user_active', 'users.created_at', 'last_login', 'tutors.*', 'grades.grade_name', \DB::raw('COUNT(reviews.tutor_id) as num_reviews'), \DB::raw('AVG(reviews.rating) as rating'))
      ->groupBy('tutors.user_id')->orderBy('pivot_created_at', 'desc')->get();

      return response()->json($saved_tutors);
    }

    //note this method does not give you full tutor profile, only the name and date
    public function ajaxtutorcontacts(Request $request)
    {
      $contacts = \App\User::findOrFail($this->id)->tutor_contacts()
      ->join('users', 'tutor_contacts.tutor_id', '=', 'users.id')
      ->select('tutor_contacts.*', 'users.fname', 'users.lname')
      ->orderBy('tutor_contacts.created_at', 'desc')
      ->get();

      return response()->json($contacts);
    }

    public function ajaxtutorreviews(Request $request)
    {
      $reviews = \App\User::findOrFail($this->id)->reviews()
      ->join('users', 'reviews.tutor_id', '=', 'users.id')
      ->select('reviews.*', 'users.fname', 'users.lname')
      ->orderBy('reviews.created_at', 'desc')
      ->get();

      return response()->json($reviews);
    }

}
