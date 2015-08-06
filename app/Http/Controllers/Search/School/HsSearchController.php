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
      if(!$request->session()->has('school_search_inputs'))
      {
        return response()->json(route('school.index'));
      }
      if(!$request->session()->has('hs_id') && !is_int($request->session()->get('hs_id')))
      {
        return response()->json(route('hs.index'));
      }

      $input = $request->all();
      $request->session()->forget('school_search_classes');

      //make sure user input isnt garbage
      foreach($input as $class_id => $class)
      {
        \App\SchoolClass::findOrFail($class_id)->levels()->where('level_num', '=', $class['level_num']);
      }

      $request->session()->put('school_search_classes', $input);

      //otherwise everything is good
      return response()->json(route('hs.showresults'));
    }

    public function run_hs_search(Request $request)
    {
      $search = new \App\Level;

      //get the search inputs from the session
      $form_inputs = $request->session()->get('school_search_inputs');
      if(empty($form_inputs)) return redirect()->route('school.index');

      $hs_id = $request->session()->get('hs_id');
      if (empty($hs_id)) return redirect()->route('hs.index');

      $classes = $request->session()->get('school_search_classes');
      if (empty($hs_id)) return redirect()->route('hs.classes');

      //get array of selected classes
      if (!empty($form_inputs['classes'])) $classes = $form_inputs['classes'];

      //get long and lat
      $zip_model = \App\Zip::where('zip_code', '=', $form_inputs['zip'])->first();
      $u_lat = $zip_model->lat;
      $u_lon = $zip_model->lon;

      //alias times
      $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];
      foreach($days as $day)
      {
        if (!empty($form_inputs[$day]) && isset($form_inputs[$day.'_checked']))
        {
          $ts = new \DateTime;
          $ts = $ts->createFromFormat( 'H:iA', $form_inputs[$day]);
          $time = $ts->format( 'H:i:s');
          $time = escape_sql($time);
          $time_alias[$day] = "CAST({$time} AS TIME)";
        }
      }


    //handle rates
    if (!empty($form_inputs['start_rate'])) $search = $search->where('rate', '>=', $form_inputs['start_rate']);
    if (!empty($form_inputs['end_rate'])) $search = $search->where('rate', '<=', $form_inputs['end_rate']);
    if (!empty($form_inputs['min_grade'])) $search = $search->where('grade', '>=', $form_inputs['min_grade']);
    if (!empty($form_inputs['max_dist'])) $max_dist = $form_inputs['max_dist'];
    //school_id
    if (!empty($hs_id)) $search = $search->where('classes.school_id', '=', $hs_id);

    //handle user classes
    $search = $search->where(function ($query) use($form_inputs, $classes){
      //build query for classes the user selects
      foreach($classes as $class_id => $class)
      {
        $query->orWhere(function ($query) use($class_id, $class, $form_inputs){
          $query->where('levels.class_id', $class_id);
          $query->where('levels.level_num', '>=', $class['level_num']);
        });
      }
    });
      //handle times
    $time_array = array();
    $search = $search->where(function ($query) use($form_inputs, $time_alias, &$time_array){
      $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];
      foreach($days as $day)
      {
        if (!empty($form_inputs[$day]) && isset($form_inputs[$day.'_checked']))
        {
          $query->orWhereRaw("(({$time_alias[$day]} BETWEEN {$day}1_start AND {$day}1_end) OR ({$time_alias[$day]} BETWEEN {$day}2_start AND {$day}2_end))");
          //create array of boolean mysql checks
          $time_array[] = "(({$time_alias[$day]} BETWEEN tutors.{$day}1_start AND tutors.{$day}1_end) OR ({$time_alias[$day]} BETWEEN tutors.{$day}2_start AND tutors.{$day}2_end))";
        }
      }
    });

    if(!empty($time_array))
    {
      $time_select = "ROUND(((".implode(' + ', $time_array).")/".count($time_array).")*100, 0) AS 'times_match'";
    } else {
      $time_select = "100 AS 'times_match'";
    }

    $num_classes = count($classes);
    //default to 100 if empty
    if($num_classes)
    {
      $class_select = "ROUND((COUNT(*)/{$num_classes})*100, 0) as 'classes_match'";
    } else {
      $class_select = "100 AS 'classes_match'";
    }

    $dist_select = sprintf("3959*ACOS(COS(RADIANS(zips.lat)) * COS(RADIANS('%s')) * COS(RADIANS(zips.lon) - RADIANS('%s')) + SIN(RADIANS(zips.lat)) * SIN(RADIANS('%s'))) AS '%s'", $u_lat, $u_lon, $u_lat, 'distance');


    if(isset($max_dist))
    {
      $dist_select2 = sprintf("ROUND(((%s - 3959*ACOS(COS(RADIANS(zips.lat)) * COS(RADIANS('%s')) * COS(RADIANS(zips.lon) - RADIANS('%s')) + SIN(RADIANS(zips.lat)) * SIN(RADIANS('%s'))))/%s)*100, 0) as %s", escape_sql($max_dist), $u_lat, $u_lon, $u_lat, escape_sql($max_dist), 'distance_match');
      $search = $search->whereRaw("zips.lat BETWEEN (? - (? / 69.0)) AND (? + (? / 69.0))", [$u_lat, $max_dist, $u_lat, $max_dist])
      ->whereRaw("zips.lon BETWEEN (? - (? / (69.0 * COS(RADIANS(?))))) AND (? + (? / (69.0 * COS(RADIANS(?)))))", [$u_lon, $max_dist, $u_lon, $u_lon, $max_dist, $u_lon])
      ->having('distance', '<=', $max_dist);
    } else {
      $dist_select2 = "100 AS 'distance_match'";
    }
    $per_page = 15;

    $search = $search->join('tutor_levels', 'levels.id', '=', 'tutor_levels.level_id')
    ->join('classes', 'classes.id', '=', 'levels.class_id')
    ->join('users', 'users.id', '=', 'tutor_levels.user_id')
    ->join('tutors', 'tutors.user_id', '=', 'tutor_levels.user_id')
    ->leftjoin('grades', 'tutors.grade', '=', 'grades.id')
    ->join('zips', 'users.zip_id', '=', 'zips.id')
    ->where('account_type', '>=', '2')
    ->where('tutors.tutor_active', '=', '1')
    ->where('tutors.profile_expiration', '>=', date('Y-m-d H:i:s'))
    ->select(\DB::raw('SQL_CALC_FOUND_ROWS tutor_levels.user_id'), \DB::raw($dist_select), \DB::raw($dist_select2), \DB::raw($class_select), \DB::raw($time_select), 'users.account_type', 'tutor_levels.user_id', 'users.id',
    'users.fname', 'users.lname', 'users.last_login', 'users.created_at','tutors.*', 'grades.*', 'zips.*')
    ->groupBy('tutor_levels.user_id')
    ->orderBy('classes_match', 'desc')
    ->orderBy('times_match', 'desc')
    ->orderBy('distance_match', 'desc')
    ->orderBy('lname', 'asc')
    ->take($per_page);


  if ($request->get('page') > 1)
  {
    $search = $search->skip(($request->get('page')-1)*$per_page);
  }
  $results = $search->get();

  $num_rows = \DB::select('SELECT FOUND_ROWS() AS num_rows')[0]->num_rows;


  $paginator = new \Illuminate\Pagination\LengthAwarePaginator($results, $num_rows, $per_page, $request->get('page'));
  $paginator->setPath($request->url());
  //return var_dump($paginator->toArray());

  if (\Auth::check())
  {
    $saved_tutors = \Auth::user()->saved_tutors()->join('users', 'tutor_id', '=', 'users.id')->get()->pluck('tutor_id')->toArray();
    return view('search/showresults', ['results' => $results, 'num_results' => $num_rows, 'paginator' => $paginator]);
  }
  else $saved_tutors = array();
    \Session::flash('feedback_warning', "For the protection of our site's tutors, we are blocking most of the site's functionality including the ability to view their profile, see reviews, and contact them. Please <a href=\"".route('auth.login')."\">login/register</a>.");
  return view('search/showresultsplain', ['results' => $results, 'num_results' => $num_rows, 'paginator' => $paginator]);

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
