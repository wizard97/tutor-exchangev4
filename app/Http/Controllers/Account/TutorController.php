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
    return view('/account/tutoring/geteditschedule');
  }

  public function geteditclasses()
  {
    /*$classes = \App\SchoolClass::with('levels')
    ->get();

    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');

    $grades = \App\Grade::all();

    //get basic tutor info
    $tutor = \App\Tutor::get_tutor_profile($this->id);
*/
    return view('/account/tutoring/editclasses');
    /*->with('tutor', $tutor)
    ->with('subjects', $subjects)
    ->with('classes', $classes);*/
  }

  public function posteditclasses(Request $request)
  {
    if ($request->has('classes') && is_array($request->input('classes')))
    {
      $classes = $request->input('classes');

      //clear existing levels
      \App\TutorLevel::where('user_id', $this->id)->delete();

      //insert new classes and levels
      foreach($classes as $class_id)
      {
        if($request->has('class_'.$class_id))
        {
          $class_level = $request->input('class_'.$class_id);
          $new_level = \App\Level::where('class_id', $class_id)->where('level_num', $class_level)->firstOrFail();
          //do the insert
          \App\Tutor::where('user_id', $this->id)->firstOrFail()->classes()->firstOrCreate(['level_id' => $new_level->id]);
        }
      }

      //count the classes
      $count = \App\Tutor::where('user_id', $this->id)->firstOrFail()->classes()->count();
      $request->session()->flash('feedback_positive', 'You have successfully updated you classes. You currently tutor '.$count.' classes.');
    }
    else \App\TutorLevel::where('user_id', $this->id)->delete();

    //insert highest level
    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
    $tutor = \App\Tutor::where('user_id', $this->id)->firstOrFail();
    foreach($subjects as $sub_name)
    {
      $html_id = 'highest_'.strtolower(str_replace(' ', '', $sub_name));
      if ($request->has($html_id)) $tutor->{$html_id} = $request->input($html_id);
      else $tutor->{$html_id} = '';
    }
    $tutor->save();

    return redirect('/account/tutoring/classes');
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

    $request->session()->flash('feedback_positive', 'You have successfully updated your tutoring info!');
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
      ->join('levels', 'levels.class_id', '=', 'classes.id')
      ->join('tutor_levels', 'tutor_levels.level_id', '=', 'levels.id')
      ->where('tutor_levels.user_id', $tutor->user_id)
      ->groupBy('schools.id')
      ->orderBy('num_classes', 'desc')
      ->select('schools.school_name', 'schools.id', \DB::raw('COUNT(*) AS num_classes'))
      ->get();

    $tutor = \App\Tutor::get_tutor_profile($this->id);
    $saved_tutors = \Auth::user()->saved_tutors()->get()->pluck('tutor_id')->toArray();
    return view('account/tutoring/myprofile')->with('tutor', $tutor)->with('subjects', $subjects)->with('saved_tutors', $saved_tutors)->with('schools', $schools);
  }

  public function pauselisting(Request $request)
  {
    $tutor = \App\Tutor::get_tutor_profile($this->id);
    $tutor_model = \App\Tutor::findOrFail($this->id);
    $tutor_model->tutor_active = false;
    $tutor_model->profile_expiration = date('Y-m-d h:i:s');
    $tutor_model->save();

    $request->session()->flash('feedback_positive', 'Your tutoring listing has been paused, you will no longer show up in tutor searches.');
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

    });

    if ($validator->fails())
    {
    return redirect(route('tutoring.runlisting'))->withErrors($validator)->withInput();
    }
    $tutor_model->tutor_active = true;
    $tutor_model->profile_expiration = date('Y-m-d h:i:s', time() + 24*60*60*$request->input('days'));
    $tutor_model->save();
    $request->session()->flash('feedback_positive', 'You have successfully started your tutoring listing!');

    return redirect(route('tutoring.dashboard'));
  }

  //used to make checklist for tutor
  private function makechecklist($tutor_id)
  {
    $tutor = \App\Tutor::get_tutor_profile($tutor_id);
    //$tutor_model = \App\Tutor::findOrFail($this->id);

    isset($tutor->grade) && isset($tutor->rate) && isset($tutor->about_me) ? $checklist['info'] = true : $checklist['info'] = false;
    !$tutor->levels()->get()->isEmpty() ? $checklist['classes'] = true : $checklist['classes'] = false;
    $tutor->tutor_active ? $checklist['active'] = true : $checklist['active'] = false;

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
