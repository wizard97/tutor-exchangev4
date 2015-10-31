<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \stdClass;

class TutorController extends Controller
{
  private $id;

  public function __construct()
  {
    $this->middleware('\App\Http\Middleware\AuthenticateTutors');
    if (\Auth::check()) {
    $this->id = \Auth::user()->id;
    }
  }

  public function getindex()
  {
    $tutor = \App\Tutor::get_tutor_profile($this->id);
    $tutor_model = \App\Tutor::findOrFail($this->id);
    $contacts = $tutor_model->contacts()->join('users', 'users.id', '=', 'tutor_contacts.user_id')->select('users.fname', 'users.lname', 'tutor_contacts.*')->orderBy('created_at', 'desc')->get();

    //calculate chart
    $total_contacts = 0;
    $contacts_asc = $contacts->reverse();

    //sign up
    $time_object = new stdClass();
    $time_object->date = strtotime($tutor->created_at)*1000;
    $time_object->total_contacts = 0;
    $contacts_array[] =  $time_object;
    foreach($contacts_asc as $contact)
    {
      $total_contacts++;
      $time_object = new stdClass();
      $time_object->date = strtotime($contact->created_at)*1000;
      $time_object->total_contacts = $total_contacts;
      $contacts_array[] =  $time_object;
    }

    //tutor checklist
    $checklist = $this->makechecklist($this->id);

    return view('/account/tutoring/index')->with('contacts', $contacts)->with('tutor', $tutor)->with('contacts_array', $contacts_array)->with('checklist', $checklist);
  }


  public function geteditschedule()
  {
    $tutor = \App\Tutor::get_tutor_profile($this->id);
    return view('/account/tutoring/editschedule')->with('tutor', $tutor);
  }


  public function getmusic()
  {
    return view('/account/tutoring/music');
  }


  public function posteditschedule(Request $request)
  {
    $tutor = \App\Tutor::findOrFail($this->id);

    $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];
    foreach($days as $day)
    {
      $feedback_day = ucfirst($day).'.';
      if (!empty($request->get($day.'1_start')) && !empty($request->get($day.'1_end')))
      {
        //first timespan is set, and possibly second as well
        $ts_start = \DateTime::createFromFormat( 'H:iA', $request->get($day.'1_start'));
        $ts_end = \DateTime::createFromFormat( 'H:iA', $request->get($day.'1_end'));
        if (intval($ts_start->format('U')) >= intval($ts_end->format('U')))
        {
          //invalid timestamp
          $request->session()->put('feedback_negative', "The start time can't be after the end time for {$feedback_day}!");
          return redirect(route('tutoring.schedule'));
        }

        //first range passed validation
        $tutor->{$day.'1_start'} = $ts_start->format('H:i:s');
        $tutor->{$day.'1_end'} = $ts_end->format( 'H:i:s');

        //check if second range is set
        if (!empty($request->get($day.'2_start')) && !empty($request->get($day.'2_end')))
        {
          //first and second timespan is set
          $ts2_start = \DateTime::createFromFormat( 'H:iA', $request->get($day.'2_start'));
          $ts2_end = \DateTime::createFromFormat( 'H:iA', $request->get($day.'2_end'));
          //make sure input is valid
          if (intval($ts2_start->format( 'U')) >= intval($ts2_end->format( 'U')))
          {
            //invalid timestamp
            $request->session()->put('feedback_negative', "The start time can't be after the end time for {$feedback_day}!");
            return redirect(route('tutoring.schedule'));
          }
          //make sure it doesnt overlap
          else if (intval($ts_end->format( 'U')) >= intval($ts2_start->format( 'U')))
          {
            //no overlap
            $request->session()->put('feedback_negative', "The second time range for {$feedback_day} must come after the first range with no overlapping timespan.");
            return redirect(route('tutoring.schedule'));
          }
          //second range passed validation
          $tutor->{$day.'2_start'} = $ts2_start->format( 'H:i:s');
          $tutor->{$day.'2_end'} = $ts2_end->format( 'H:i:s');
        }
        else {
          //empty out second range
          $tutor->{$day.'2_start'} = NULL;
          $tutor->{$day.'2_end'} = NULL;
        }

      }
      else {
        //check if second range is set, but not first
        $tutor->{$day.'1_start'} = NULL;
        $tutor->{$day.'1_end'} = NULL;
        //if second set, but first is empty
        if (!empty($request->get($day.'2_start')) && !empty($request->get($day.'2_end')))
        {
          //second timespan only one set, so move it to first one
          $ts_start = \DateTime::createFromFormat( 'H:iA', $request->get($day.'2_start'));
          $ts_end = \DateTime::createFromFormat( 'H:iA', $request->get($day.'2_end'));
          if (intval($ts_start->format('U')) >= intval($ts_end->format('U')))
          {
            //invalid timestamp
            $request->session()->put('feedback_negative', "The start time can't be after the end time for {$feedback_day}!");
            return redirect(route('tutoring.schedule'));
          }
          //first range passed validation
          $tutor->{$day.'1_start'} = $ts_start->format( 'H:i:s');
          $tutor->{$day.'1_end'} = $ts_end->format( 'H:i:s');
          $tutor->{$day.'2_start'} = NULL;
          $tutor->{$day.'2_end'} = NULL;
        }
      }
    }
    //update the db
    $tutor->save();
    $request->session()->put('feedback_positive', "Your tutoring schedule/availability has been updated!");

    return redirect(route('tutoring.schedule'));
  }


  public function geteditclasses()
  {
    $tutor = \App\Tutor::findOrFail($this->id);
    //get tutor schools
    $schools = $tutor->schools()
      ->leftJoin('classes', 'classes.school_id', '=', 'schools.id')
      ->leftJoin('levels', 'levels.class_id', '=', 'classes.id')
      ->leftJoin('tutor_levels', function($join)
      {
        $join->on('levels.id', '=', 'tutor_levels.level_id');
        $join->on('tutor_levels.user_id','=', \DB::raw($this->id));
      })
      ->groupBy('schools.id')
      ->orderBy('num_classes', 'desc')
      ->select('schools.school_name', 'schools.id', \DB::raw('COUNT(DISTINCT tutor_levels.id) AS num_classes'))
      ->get();
    return view('/account/tutoring/editclasses')->with('schools', $schools)->with('tutor', $tutor);

  }

  //gets the classes for the school
  public function ajaxgetschoolclasses(Request $request)
  {
    $hs_id = $request->get('school_id');
    \App\School::findOrFail($hs_id);
    //make sure it has at elast one level
    $classes = \App\SchoolClass::where('classes.school_id', '=', $hs_id)
    ->join('school_subjects', 'classes.subject_id', '=', 'school_subjects.id')
    ->select('classes.*', 'school_subjects.subject_name')
    ->orderBy('class_name', 'asc')->get();

    foreach ($classes as &$class)
    {
      $class->levels = \App\Level::
      where('classes.school_id', '=', $hs_id)
      ->where('classes.id', '=', $class->id)
      ->join('classes', 'classes.id', '=', 'levels.class_id')
      ->leftJoin('tutor_levels', function($join)
      {
        $join->on('levels.id', '=', 'tutor_levels.level_id');
        $join->on('tutor_levels.user_id','=', \DB::raw($this->id));
      })
      ->orderBy('level_num', 'desc')
      ->select('levels.*', \DB::raw("CASE WHEN tutor_levels.user_id IS NULL THEN 'FALSE' ELSE 'TRUE' END AS selected"))
      ->get();
    }

    return response()->json(['data' => $classes]);
  }

  public function ajaxgettutorschoolclasses(Request $request)
  {
    $school_id = $request->get('school_id');
    $tutor = \App\Tutor::findOrFail($this->id);

    //get the tutor classes for the school_id
    //make sure tutor has school
    $classes = $tutor->levels()
    ->join('classes', 'classes.id', '=', 'levels.class_id')
    ->join('school_subjects', 'classes.subject_id', '=', 'school_subjects.id')
    ->where('classes.school_id', '=', $school_id)
    ->select('classes.class_name', 'school_subjects.subject_name', 'levels.*')
    ->get();

    return response()->json(['data' => $classes]);
  }

  public function posteditclasses(Request $request)
  {
    $this->validate($request, [
    'school_id' => 'required|exists:schools,id',
    'level_ids' => 'array',
    ]);

    $tutor = \App\Tutor::findOrFail($this->id);
    $school_id = $request->input('school_id');

    $school = \App\School::findOrFail(intval($school_id));

    //make sure tutor tutors that school
    $tutor->schools()->findOrFail($school_id);

    $level_ids = $request->input('level_ids');
    //remove old classes
    \App\Tutor::findOrFail($this->id)->levels()
      ->join('classes', 'classes.id', '=', 'levels.class_id')
      ->where('classes.school_id', '=', $school_id)
      ->detach();

    //insert new levels
    if (!empty($level_ids))
    {
      foreach ($level_ids as $level_id)
      {
        //make sure not to insert redundant level for a class

        //find class_id for level
        $class_id = \App\Level::findOrFail($level_id)->class_id;
        //make sure it is for right school
        $school->classes()->findOrFail($class_id);

        if ($tutor->levels()->where('levels.class_id', '=', $class_id)
              ->get()->isEmpty())
            {
              //there is no duplicate class, so do the insert
              $tutor->levels()->attach($level_id);
            }

      }
      $num_classes = $tutor->levels()->join('classes', 'classes.id', '=', 'levels.class_id')->where('school_id', $school_id)->count();
      $request->session()
        ->put('feedback_positive', "You have successfully updated the classes you tutor for {$school->school_name}. You currently are tutoring {$num_classes} class/classes.");
    }
    else $request->session()->put('feedback_positive', "You have successfully removed all your classes for {$school->school_name}.");

    return response()->json([]);
  }
  //gets the classes for the school
  public function ajaxgetmiddleclasses(Request $request)
  {
    //make sure it has at elast one level
    $classes = \App\MiddleClass::join('middle_subjects', 'middle_subjects.id', '=', 'middle_classes.middle_subject_id')
    ->leftJoin('tutor_middle_classes', function($join)
    {
      $join->on('tutor_middle_classes.middle_classes_id', '=', 'middle_classes.id');
      $join->on('tutor_middle_classes.tutor_id','=', \DB::raw($this->id));
    })
    ->select('middle_classes.*', 'middle_subjects.subject_name', \DB::raw("CASE WHEN tutor_middle_classes.tutor_id IS NULL THEN 'FALSE' ELSE 'TRUE' END AS selected"))
    ->orderBy('class_name', 'asc')->get();

    return response()->json(['data' => $classes]);
  }
  public function ajaxgettutormiddleclasses(Request $request)
  {
    $tutor = \App\Tutor::findOrFail($this->id);

    //get the tutor classes for the school_id
    //make sure tutor has school
    $classes = $tutor->middle_classes()
    ->join('middle_subjects', 'middle_classes.middle_subject_id', '=', 'middle_subjects.id')
    ->select('middle_classes.class_name', 'middle_subjects.subject_name', 'middle_classes.id')
    ->get();

    return response()->json(['data' => $classes]);
  }

  public function posteditmiddleclasses(Request $request)
  {
    $this->validate($request, [
    'class_ids' => 'array',
    ]);

    $tutor = \App\Tutor::findOrFail($this->id);

    $class_ids = $request->input('class_ids');
    //remove old classes
    \App\Tutor::findOrFail($this->id)->middle_classes()->detach();

    //insert new levels
    if (!empty($class_ids))
    {
      foreach ($class_ids as $cid)
      {
        //make sure not to insert redundant level for a class

        //find class for class_id
        $class = \App\MiddleClass::findOrFail($cid);

        if ($tutor->middle_classes()->where('middle_classes.id', '=', $cid)->get()->isEmpty())
        {
          //there is no duplicate class, so do the insert
          $tutor->middle_classes()->attach($cid);
        }

      }
      $num_classes = $tutor->middle_classes()->count();
      $request->session()
        ->put('feedback_positive', "You have successfully updated the middle school and below classes you tutor. You currently are tutoring {$num_classes} class/classes.");
    }
    else $request->session()->put('feedback_positive', "You have successfully removed all your middle school and below classes.");

    return response()->json([]);
  }

  public function geteditinfo()
  {
    $tutor = \App\Tutor::get_tutor_profile($this->id);

    $grades = \App\Grade::all();
    return view('/account/tutoring/editinfo')
    ->with('tutor', $tutor)
    ->with('grades', $grades);
  }

  public function posteditinfo(Request $request)
  {
    $this->validate($request, [
    'age' => 'numeric|min:13|max:100',
    'grade' => 'required|numeric',
    'rate' => 'required|numeric|between:10,150',
    'about_me' => ''
    ]);
    //make sure protected prevents them from changing id and such
    $tutor = \App\Tutor::where('user_id', $this->id)->firstOrFail();
    $tutor->age = $request->input('age');
    $tutor->grade = $request->input('grade');
    $tutor->rate = $request->input('rate');
    $tutor->about_me = $request->input('about_me');
    $tutor->save();

    $request->session()->put('feedback_positive', 'You have successfully updated your tutoring info!');
    return redirect('/account/tutoring/info');
  }

  public function getmyprofile()
  {
    $tutor = \App\Tutor::findOrFail($this->id);
    //get levels and join on class info, get all the subjects
    $subjects = $tutor->levels()
    ->join('classes', 'levels.class_id', '=', 'classes.id')
    ->join('school_subjects', 'classes.subject_id', '=', 'school_subjects.id')
    ->groupBy('subject_id')
    ->select('classes.school_id', 'classes.subject_id', 'subject_name', \DB::raw('count(*) AS num_classes'))
    ->get()
    ->groupBy('school_id');

    //get tutor schools
    $schools = $tutor->schools()
      ->leftJoin('classes', 'classes.school_id', '=', 'schools.id')
      ->leftJoin('levels', 'levels.class_id', '=', 'classes.id')
      ->leftJoin('tutor_levels', function($join)
      {
        $join->on('levels.id', '=', 'tutor_levels.level_id');
        $join->on('tutor_levels.user_id','=', \DB::raw($this->id));
      })
      ->groupBy('schools.id')
      ->orderBy('num_classes', 'desc')
      ->select('schools.school_name', 'schools.id', \DB::raw('COUNT(DISTINCT tutor_levels.id) AS num_classes'))
      ->get();

    $reviews = $tutor->reviews()->join('users', 'users.id', '=', 'reviews.tutor_id')
      ->select('reviews.*', 'users.fname', 'users.lname')
      ->orderBy('reviews.created_at', 'desc')
      ->get();

    $tutor = \App\Tutor::get_tutor_profile($this->id);
    $saved_tutors = \Auth::user()->saved_tutors()->get()->pluck('tutor_id')->toArray();
    return view('account/tutoring/myprofile')->with('tutor', $tutor)->with('subjects', $subjects)->with('saved_tutors', $saved_tutors)->with('schools', $schools)
      ->with('reviews', $reviews);
  }

  public function pauselisting(Request $request)
  {
    $tutor = \App\Tutor::get_tutor_profile($this->id);
    $tutor_model = \App\Tutor::findOrFail($this->id);
    $tutor_model->tutor_active = false;
    $tutor_model->profile_expiration = date('Y-m-d h:i:s');
    $tutor_model->save();

    $request->session()->put('feedback_positive', 'Your tutoring listing has been paused, you will no longer show up in tutor searches.');
    return redirect(route('tutoring.dashboard'));
  }

  public function runlisting()
  {
    $tutor = \App\Tutor::get_tutor_profile($this->id);
    return view('/account/tutoring/runlisting')->with('tutor', $tutor);
  }

  public function submitlisting(Request $request)
  {
     $validator = \Validator::make($request->all(), [
    'days' => 'numeric|min:1|max:60',
    ]);
    $tutor = \App\Tutor::get_tutor_profile($this->id);
    $tutor_model = \App\Tutor::findOrFail($this->id);

    $checklist = $this->makechecklist($this->id);

    $validator->after(function($validator) use($checklist)
    {
      if ($checklist['info'] != true) $validator->errors()->add('Info', 'Your tutoring info section is incomplete.');
      if ($checklist['classes'] != true) $validator->errors()->add('Classes', 'Your tutoring classes section is incomplete.');
      if ($checklist['schedule'] != true) $validator->errors()->add('Schedule', 'Your tutoring schedule section is incomplete.');

    });

    if ($validator->fails())
    {
    return redirect(route('tutoring.runlisting'))->withErrors($validator)->withInput();
    }
    $tutor_model->tutor_active = true;
    $tutor_model->profile_expiration = date('Y-m-d h:i:s', time() + 24*60*60*$request->input('days'));
    $tutor_model->save();
    $request->session()->put('feedback_positive', 'You have successfully started your tutoring listing!');

    return redirect(route('tutoring.dashboard'));
  }

  public function ajaxgetschools(Request $request)
  {
    $schools = \App\Tutor::findOrFail($this->id)->schools()->get();

    return response()->json(['data' => $schools]);
  }

  //remove or start music
  public function ajaxstartstopmusic(Request $request)
  {
    $this->validate($request, [
    'tutors_music' => 'required|boolean',
    ]);

    $tutor = \App\Tutor::findOrFail($this->id);
    //set the tutor as tutoring music
    if ($request->get('tutors_music'))
    {
      $tutor->tutors_music = true;

      $request->session()->put('feedback_positive', 'You now tutor music!');
    }
    else
    {
      //remove everything
      $tutor->music()->detach();
      //the tutuor does not tutor music
      $tutor->tutors_music = false;

      $request->session()->put('feedback_positive', 'You just stopped tutoring music!');
    }
    $tutor->save();

    return response()->json(['tutors_music' => $tutor->tutors_music, 'data' => $tutor->music]);
  }

  public function ajaxgetmusic(Request $request)
  {
    $tutor = \App\Tutor::findOrFail($this->id);
    return response()->json(['data' => $tutor->music]);
  }

  //used to make checklist for tutor
  private function makechecklist($tutor_id)
  {
    $tutor = \App\Tutor::get_tutor_profile($tutor_id);
    //$tutor_model = \App\Tutor::findOrFail($this->id);

    isset($tutor->grade) && isset($tutor->rate) && isset($tutor->about_me) ? $checklist['info'] = true : $checklist['info'] = false;
    !$tutor->levels()->get()->isEmpty() ? $checklist['classes'] = true : $checklist['classes'] = false;
    $tutor->tutor_active ? $checklist['active'] = true : $checklist['active'] = false;

    //music check
    ($tutor->music()->get()->isEmpty() && $tutor->tutors_music) ? $checklist['music'] = false : $checklist['music'] = true;

    $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];

    $checklist['schedule'] = false;
    foreach($days as $day)
    {
        if((isset($tutor->{"{$day}1_start"}) && isset($tutor->{"{$day}1_end"})) || (isset($tutor->{"{$day}2_start"}) && isset($tutor->{"{$day}2_end"})))
        {
          $checklist['schedule'] = true;
          break;
        }
    }

    return $checklist;
  }

}
