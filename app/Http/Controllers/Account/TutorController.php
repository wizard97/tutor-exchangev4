<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TutorController extends Controller
{
  private $id;

  protected $fillable = ['age', 'grade', 'rate', 'about_me'];

  public function __construct()
  {
    $this->middleware('\App\Http\Middleware\AuthenticateTutors');
    if (\Auth::check()) {
    $this->id = \Auth::user()->id;
    }
  }

  public function getindex()
  {
    return view('/account/tutoring/index');
  }

  public function geteditclasses()
  {
    $classes = \App\SchoolClass::with('class_levels')->orderBy('class_order', 'asc')
    ->get()
    ->groupBy('class_type');

    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');

    $grades = \App\Grade::all();

    //get basic tutor info
    $tutor = \App\Tutor::get_tutor_profile($this->id);

    return view('/account/tutoring/editclasses')
    ->with('tutor', $tutor)
    ->with('subjects', $subjects)
    ->with('classes', $classes);
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
    //get subjects
    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
    //get basic tutor info
    $tutor = \App\Tutor::get_tutor_profile($this->id);
    return view('/account/tutoring/myprofile')->with('tutor', $tutor)->with('subjects', $subjects);
  }
}
