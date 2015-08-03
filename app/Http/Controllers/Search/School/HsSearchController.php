<?php
namespace App\Http\Controllers\Search\School;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HsSearchController extends Controller
{

  //pick hs
  public function index()
  {
    return view('search/school/schools');
  }

  public function submit_school(Request $request)
  {
    //if school_search_inputs not set redirect back
    if(!$request->session()->has('school_search_inputs'))
    {
      return redirect()->route('school.index');
    }

    $this->validate($request, [
      'school_name' => 'required|string'
      ]);

    //figure out their school
    $school_name = $request->input('school_name');
    $results = $this->query($school_name);
    if(empty($results)) return redirect()->back();
    $school_id = json_decode($results)[0]->school_id;

    $inputs = $request->session()->pull('hs_id');

    $request->session()->put('hs_id', $school_id);

    return redirect()->route('hs.classes');
  }

  public function classes(Request $request)
  {
    //if hs_id not set redirect back

    if(!$request->session()->has('hs_id') && !is_int($request->session()->get('hs_id')))
    {
      return redirect()->route('hs.index');
    }


    $inputs = $request->session()->get('school_search_inputs');
    $hs_id = $request->session()->get('hs_id');

    //make sure it has at elast one level
    $classes = \App\SchoolClass::where('school_id', '=', $hs_id)->orderBy('class_name', 'asc')->get();

    //return (\App\SchoolClass::where('school_id', '=', $hs_id)->orderBy('class_name', 'asc')->toSql());
    $levels = \App\Level::where('classes.school_id', '=', $hs_id)->join('classes', 'classes.id', '=', 'levels.class_id')->orderBy('level_num', 'desc')->get()->groupBy('class_id');
    //  $classes->merge($levels);
    $subjects = \App\SchoolClass::where('school_id', '=', $hs_id)->groupBy('class_type')->get()->pluck('class_type');
    $grades = \App\Grade::all();

    \JavaScript::put([
      'classes' => $classes,
      'levels' => $levels,
      ]);

      return view('search/school/classes')->with('classes', $classes)->with('subjects', $subjects)->with('grades', $grades);
    }

    public function submit_classes(Request $request)
    {

    }

    public function run_hs_search()
    {
      $search = new \App\Level;

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
            $query->orWhereRaw("(:time BETWEEN {$day}1_start AND {$day}1_end) OR (:time BETWEEN {$day}2_start AND {$day}2_end)", array(':time' => $time));
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
        $time_array[] = "(({$time} BETWEEN tutors.{$day}1_start AND tutors.{$day}1_end) OR ({$time} BETWEEN tutors.{$day}2_start AND tutors.{$day}2_end))";
      }
    }
    //default to 100 if empty
    if(!empty($time_array))
    {
      $time_select = "ROUND ((({implode(' + ', $time_array)})/{count($time_array)})*100, 0) AS times_match";
    } else {
      $time_select = '100 AS times_match';
    }
    //default to 100 if empty
    if($selected != 0)
    {
      $class_select = "ROUND((COUNT(*)/{$selected})*100, 0) as classes_match";
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

    return $search->toSql();
  }


  public function query($query)
  {
    $keys = preg_split("/[\s,.]+/", trim(urldecode($query)));
    $num_keys = count($keys);

    $search = \App\School::join('zips', 'schools.zip_id', '=', 'zips.id');
    //make queries more complex until we stop getting results, then back up one
    for ($i = 0; $i < $num_keys; $i++)
    {
        $previous = $search;

        $search = $search->where(function ($query) use ($keys, $i){
          $query->orWhere('school_name', 'LIKE', '%'.$keys[$i].'%')
          ->orWhere('zips.zip_code', 'LIKE', '%'.$keys[$i].'%')
          ->orWhere('zips.city', 'LIKE', '%'.$keys[$i].'%')
          ->orWhere('zips.state_prefix', 'LIKE', '%'.$keys[$i].'%');
        });

          if ($search->count() == 0) break;
    }
    $matches = $previous->select('zips.*', 'schools.school_name', 'schools.id AS school_id', \DB::raw("CONCAT_WS(', ', school_name, CONCAT(UCASE(LEFT(city, 1)),LCASE(SUBSTRING(city, 2))), CONCAT_WS(' ',state_prefix, zips.zip_code)) as response"))
    ->take(10)
    ->get();

    return $matches->toJson();
  }

  public function prefetch()
  {
    //get most popular schools, choose based on most tutors
    $prefetch = \App\School::join('zips', 'schools.zip_id', '=', 'zips.id')
    ->join('tutor_schools', 'schools.id', '=', 'tutor_schools.school_id')
    ->select('zips.*', 'schools.school_name', 'schools.id AS school_id', \DB::raw("COUNT(*) as count"), \DB::raw("CONCAT_WS(', ', school_name, CONCAT(UCASE(LEFT(city, 1)),LCASE(SUBSTRING(city, 2))), CONCAT_WS(' ',state_prefix, zips.zip_code)) as response"))
    ->groupBy('schools.id')
    ->orderBy('count', 'desc')
    ->take(20)
    ->get();


    return $prefetch->toJson();
  }

}
