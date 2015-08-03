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
    $saved_tutors = \Auth::user()->saved_tutors()->join('users', 'tutor_id', '=', 'users.id')->get()->pluck('tutor_id')->toArray();
    return view('search/showtutorprofile')->with('tutor', $tutor)->with('subjects', $subjects)->with('saved_tutors', $saved_tutors);
  }

  public function ajaxcontactjson(Request $request)
  {
    $this->validate($request, [
      'userid' => 'required|exists:tutors,user_id'
      ]);

      $tutor = \App\Tutor::get_tutor_profile($request->input('userid'));

      $data['name'] = $tutor->fname.' '.$tutor->lname;
      $data['tutor_profile'] = route('search.showtutorprofile', ['id' => $request->input('userid')]);
      $data['post_url'] = route('search.sendmessage');

      return response()->json($data);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
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


          $search = \Auth::user()->saved_tutors()->join('users', 'tutor_id', '=', 'users.id')->where('tutor_id', $id)->first();

          if (is_null($search))
          {
            $saved_model = new \App\SavedTutor;
            $saved_model->user_id = \Auth::user()->id;
            $saved_model->tutor_id = $id;
            $saved_model->save();
            \Session::flash('feedback_positive', 'You have successfully added '.$tutor->fname.' '.$tutor->lname.' to your saved tutors.');
            return response()->json([$id => true]);
          }

          else
          {
            \App\SavedTutor::where('user_id', \Auth::user()->id)->where('tutor_id', $id)->delete();
            \Session::flash('feedback_positive', 'You have successfully removed '.$tutor->fname.' '.$tutor->lname.' from your saved tutors.');
            return response()->json([$id => false]);
          }

        }
      }
