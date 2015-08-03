<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

  public function __construct(Request $request)
  {
    //$request->session()->keep(['tutor_search_inputs']);
  }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      $classes = \App\SchoolClass::with('levels')->orderBy('class_order', 'asc')
      ->get()
      ->groupBy('class_type');
      $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
      $grades = \App\Grade::all();
      return view('search/index')->with('classes', $classes)->with('subjects', $subjects)->with('grades', $grades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function search(Request $request)
    {
      $this->validate($request, [
      'start_rate' => 'min:0|numeric',
      'end_rate' => 'min:0|numeric',
      'grade' => 'numeric',
      ]);
      $input = $request->all();
      //flash form data into session
      $request->session()->put('tutor_search_inputs', $input);
      //searchcounter++
      \App\Stat::increment('searches');

      return redirect('search/showresults');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
     public function showresults(Request $request)
     {
       //get the classes and levels, and join that on the tutor_levels table
      $search = new \App\Level;
      //$search = $search->findtutors();
        //loop thorugh the form inputs
        $selected = 0;

        //get the search inputs from the session
        $form_inputs = $request->session()->get('tutor_search_inputs');
        $classes = array();

        //get array of selected classes
        if (!empty($form_inputs['classes'])) $classes = $form_inputs['classes'];

        //handle rates
        if (!empty($form_inputs['start_rate'])) $search->where('rate', '>=', $form_inputs['start_rate']);
        if (!empty($form_inputs['end_rate'])) $search->where('rate', '<=', $form_inputs['end_rate']);
        if (!empty($form_inputs['min_grade'])) $search->where('grade', '>=', $form_inputs['min_grade']);

        //handle user classes
        $search = $search->where(function ($query) use($form_inputs, &$selected, $classes){
          //build query for classes the user selects
          $query->where(function ($query) use($form_inputs, &$selected, $classes){
            foreach($classes as $class_id)
            {
              if (!empty($form_inputs['class_'.$class_id]))
              {
                $query->orWhere(function ($query) use($class_id, $form_inputs, &$selected){
                  $query->where('levels.class_id', $class_id);
                  $query->where('levels.level_num', '>=', $form_inputs['class_'.$class_id]);
                  $selected++;
                });
              }
            }
          });

          //handle times
          $query->where(function ($query) use($form_inputs){

            $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];

            foreach($days as $day)
            {
              if (!empty($form_inputs[$day]))
              {
                $ts = DateTime::createFromFormat( 'H:iA', $form_inputs[$day]);
                $time = $ts->format( 'H:i:s');
                $query->orWhereRaw('(:time BETWEEN {$day}1_start AND {$day}1_end) OR (:time BETWEEN {$day}2_start AND {$day}2_end)', array(':time' => $time));
              }
            }
          });

        });

        //create raw sql query, DateTime should escape user input
        //create seach query, pass in $selected by refrence
        $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];
        foreach ($days as $day)
        {
          if (!empty($form_inputs[$day]))
          {
            $ts = DateTime::createFromFormat( 'H:iA', $form_inputs[$day]);
            $time = $ts->format( 'H:i:s');
            $time_array[] = '(({$time} BETWEEN tutors.{$day}1_start AND tutors.{$day}1_end) OR ({$time} BETWEEN tutors.{$day}2_start AND tutors.{$day}2_end))';
          }
        }
        //default to 100 if empty
        if(!empty($time_array))
        {
          $time_select = 'ROUND ((({implode(" + ", $time_array)})/{count($time_array)})*100, 0) AS times_match';
        } else {
          $time_select = '100 AS times_match';
        }
        //default to 100 if empty
        if($selected != 0)
        {
          $class_select = 'ROUND((COUNT(*)/{$selected})*100, 0) as classes_match';
        } else {
          $class_select = '100 AS classes_match';
        }

        $search = $search->join('tutor_levels', 'levels.id', '=', 'tutor_levels.level_id')
        ->join('users', 'users.id', '=', 'tutor_levels.user_id')
        ->join('tutors', 'tutors.user_id', '=', 'tutor_levels.user_id')
        ->leftjoin('grades', 'tutors.grade', '=', 'grades.id')
        ->where('account_type', '>=', '2')
        ->where('tutors.tutor_active', '=', '1')
        ->where('tutors.profile_expiration', '>=', date('Y-m-d H:i:s'))
        ->select(\DB::raw($class_select), \DB::raw($time_select), 'users.account_type', 'tutor_levels.user_id', 'users.id',
        'users.fname', 'users.lname', 'users.last_login', 'users.created_at','tutors.*', 'grades.*')
        ->groupBy('tutor_levels.user_id')
        ->orderBy('class_matches', 'desc')
        ->orderBy('lname', 'asc');

        /*
        //array with key user ids, containing an object of id and sqlcount
        $id_count = $search->get()->keyBy('user_id')->toArray();

       //user_id's who match criteria for array
       $tutors_id = array_keys($id_count);

       if (!empty($tutors_id))
       {
       $ids = implode(',', $tutors_id);
       $tutors_object =  new \App\Tutor;
       $basic_info = $tutors_object->tutorinfo($tutors_id)
       ->orderByRaw(\DB::raw("FIELD(tutors.user_id, $ids)"))
       ->select('users.id', 'users.fname', 'users.lname', 'users.account_type', 'users.last_login', 'users.last_login', 'users.created_at','tutors.*', 'grades.*')
       ->paginate(15);
       */
       return $search->toSql();
       $basic_info = $search->get();
       return var_dump($basic_info->toArray());
      if (!empty($basic_info))
      {
       // function adds tutor match%, classes and reviews
       $results = \App\Tutor::insert_classes_reviews($basic_info);

      }
      else $results = array();

      $num_results = count($search->count());

      //get users saved tutors, stupid Laravel contins doesnt work
      if (\Auth::check())
      {
        $saved_tutors = \Auth::user()->saved_tutors()->join('users', 'tutor_id', '=', 'users.id')->get()->pluck('tutor_id')->toArray();
        return view('search/showresults', ['results' => $results, 'num_results' => $num_results, 'saved_tutors' => $saved_tutors]);
      }
      else $saved_tutors = array();
        \Session::flash('feedback_warning', "For the protection of our site's tutors, we are blocking most of the site's functionality including the ability to view their profile, see reviews, and contact them. Please <a href=\"".route('auth.login')."\">login/register</a>.");
      return view('search/showresultsplain', ['results' => $results, 'num_results' => $num_results, 'saved_tutors' => $saved_tutors]);
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
