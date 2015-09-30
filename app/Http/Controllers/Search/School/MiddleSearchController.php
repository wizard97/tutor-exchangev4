<?php

namespace App\Http\Controllers\Search\School;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MiddleSearchController extends Controller
{
  public function classes(Request $request)
  {
    $inputs = $request->session()->get('school_search_inputs');

    //make sure it has at elast one level
    $classes = \App\MiddleClass::join('middle_subjects', 'middle_classes.middle_subject_id', '=', 'middle_subjects.id')
    ->select('middle_classes.*', 'middle_subjects.subject_name')
    ->orderBy('class_name', 'asc')->get();


    \JavaScript::put([
      'classes' => $classes,
      ]);

      return view('search/school/middleclasses')->with('classes', $classes);
    }

    public function submit_classes(Request $request)
    {
      if(!$request->session()->has('school_search_inputs'))
      {
        return response()->json(route('school.index'));
      }

      if (isset($request->all()['class_ids'])) $input = $request->all()['class_ids'];
      else $input = [];
      $request->session()->forget('middle_search_classes');


      //make sure user input isnt garbage
      foreach($input as $class_id => $class)
      {
        \App\MiddleClass::findOrFail($class);
      }

      $request->session()->put('middle_search_classes', $input);

      \App\Stat::incr_search();

      //otherwise everything is good
      return response()->json(route('middle.showresults'));
    }

    public function run_search(Request $request)
    {
      $search = new \App\MiddleClass;


      //get the search inputs from the session
      $form_inputs = $request->session()->get('school_search_inputs');
      if(empty($form_inputs)) return redirect()->route('school.index');

      $classes = $request->session()->get('middle_search_classes');
      if (is_null($classes)) return redirect()->route('middle.classes');


      //get long and lat
      if (\Auth::check())
      {
        $u_lat = \Auth::user()->lat;
        $u_lon = \Auth::user()->lon;
      }
      else
      {
        $zip_model = \App\Zip::where('zip_code', '=', $form_inputs['zip'])->firstOrFail();
        $u_lat = $zip_model->lat;
        $u_lon = $zip_model->lon;
      }

      //alias times
      $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];
      $time_alias = array();
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
    if (!empty($hs_id)) $search->where('classes.school_id', '=', $hs_id);

    //handle user classes
    if (!empty($classes)) $search->whereIn('middle_classes.id', $classes);
      //handle times
    $time_array = array();
    $search->where(function ($query) use($form_inputs, $time_alias, &$time_array){
      $days = ['mon', 'tues', 'wed', 'thurs', 'fri', 'sat', 'sun'];
      foreach($days as $day)
      {
        if (!empty($form_inputs[$day]) && isset($form_inputs[$day.'_checked']))
        {
          $query->orWhereRaw("(({$time_alias[$day]} BETWEEN {$day}1_start AND {$day}1_end) OR ({$time_alias[$day]} BETWEEN {$day}2_start AND {$day}2_end))");
          //create array of boolean mysql checks
          $time_array[] = "COALESCE((({$time_alias[$day]} BETWEEN tutors.{$day}1_start AND tutors.{$day}1_end) OR ({$time_alias[$day]} BETWEEN tutors.{$day}2_start AND tutors.{$day}2_end)), 0)";
        }
      }
    });

    //tutor type
    switch ($form_inputs['tutor_type'])
    {
      case 'standard':
        $search->where('users.account_type', '2');
        break;
      case 'professional':
        $search->where('users.account_type', '3');
        break;
      case 'all':
        $search->where('users.account_type', '>=', '2');
        break;
    }

    //count and search query diverge here
    $count_query = clone $search;

    $num_availability = count($time_array);

    if(!empty($time_array))
    {
      $time_select = "ROUND(((".implode(' + ', $time_array).")/{$num_availability})*100, 0) AS 'times_match'";
    } else {
      $time_select = "100 AS 'times_match'";
    }

    if (!empty($time_array)) $time_select2 = "(".implode(' + ', $time_array).") AS availability_count";
    else $time_select2 = "0 AS availability_count";

    $num_classes = count($classes);
    //default to 100 if empty
    if($num_classes)
    {
      $class_select = "ROUND((COUNT(DISTINCT tutor_middle_classes.middle_classes_id)/{$num_classes})*100, 0) as 'classes_match'";
    } else {
      $class_select = "100 AS 'classes_match'";
    }

    $class_select2 = "COUNT(DISTINCT tutor_middle_classes.middle_classes_id) AS classes_count";


    $dist_select = sprintf("ROUND(3959*ACOS(COS(RADIANS(users.lat)) * COS(RADIANS('%s')) * COS(RADIANS(users.lon) - RADIANS('%s')) + SIN(RADIANS(users.lat)) * SIN(RADIANS('%s'))), 0) AS '%s'", $u_lat, $u_lon, $u_lat, 'distance');

    if(isset($max_dist))
    {
      $dist_select2 = sprintf("ROUND(((%s - 3959*ACOS(COS(RADIANS(users.lat)) * COS(RADIANS('%s')) * COS(RADIANS(users.lon) - RADIANS('%s')) + SIN(RADIANS(users.lat)) * SIN(RADIANS('%s'))))/%s)*100, 0) as %s", escape_sql($max_dist), $u_lat, $u_lon, $u_lat, escape_sql($max_dist), 'distance_match');
      $search->whereRaw("users.lat BETWEEN (? - (? / 69.0)) AND (? + (? / 69.0))", [$u_lat, $max_dist, $u_lat, $max_dist])
      ->whereRaw("users.lon BETWEEN (? - (? / (69.0 * COS(RADIANS(?))))) AND (? + (? / (69.0 * COS(RADIANS(?)))))", [$u_lon, $max_dist, $u_lon, $u_lon, $max_dist, $u_lon])
      ->having('distance', '<=', $max_dist);
    } else {
      $dist_select2 = "100 AS 'distance_match'";
    }
    $per_page = 15;


    //build count
    $count_query
    ->whereRaw("3959*ACOS(COS(RADIANS(users.lat)) * COS(RADIANS(?)) * COS(RADIANS(users.lon) - RADIANS(?)) + SIN(RADIANS(users.lat)) * SIN(RADIANS(?))) <= ?", [$u_lat, $u_lon, $u_lat, $max_dist])
    ->whereRaw("users.lat BETWEEN (? - (? / 69.0)) AND (? + (? / 69.0))", [$u_lat, $max_dist, $u_lat, $max_dist])
    ->whereRaw("users.lon BETWEEN (? - (? / (69.0 * COS(RADIANS(?))))) AND (? + (? / (69.0 * COS(RADIANS(?)))))", [$u_lon, $max_dist, $u_lon, $u_lon, $max_dist, $u_lon]);

    $res_count = $count_query
    ->join('tutor_middle_classes', 'middle_classes.id', '=', 'tutor_middle_classes.middle_classes_id')
    ->join('users', 'users.id', '=', 'tutor_middle_classes.tutor_id')
    ->join('tutors', 'tutors.user_id', '=', 'tutor_middle_classes.tutor_id')
    ->join('zips', 'users.zip_id', '=', 'zips.id')
    ->where('tutors.tutor_active', '=', '1')
    ->where('tutors.profile_expiration', '>=', date('Y-m-d H:i:s'))
    ->select(\DB::raw($dist_select), 'tutor_middle_classes.tutor_id', \DB::raw('COUNT(DISTINCT tutor_middle_classes.tutor_id) AS num_rows'))->get();
    //figure out num of rows
    $num_rows = $res_count->first()->toArray()['num_rows'];

    //finish building search
    $search->join('tutor_middle_classes', 'middle_classes.id', '=', 'tutor_middle_classes.middle_classes_id')
    ->join('users', 'users.id', '=', 'tutor_middle_classes.tutor_id')
    ->join('tutors', 'tutors.user_id', '=', 'tutor_middle_classes.tutor_id')
    ->leftjoin('grades', 'tutors.grade', '=', 'grades.id')
    ->leftjoin('reviews', 'reviews.tutor_id', '=', 'tutor_middle_classes.tutor_id')
    ->join('zips', 'users.zip_id', '=', 'zips.id')
    ->where('tutors.tutor_active', '=', '1')
    ->where('tutors.profile_expiration', '>=', date('Y-m-d H:i:s'))
    ->select(\DB::raw($dist_select), \DB::raw($dist_select2), \DB::raw($class_select), \DB::raw($class_select2), \DB::raw($time_select), \DB::raw($time_select2), \DB::raw('AVG(reviews.rating) AS avg_rating'), 'users.account_type', 'users.id',
    'users.fname', 'users.lname', 'users.last_login', 'users.created_at', 'users.account_type', 'tutors.*', 'grades.*', 'zips.*')
    ->groupBy('tutor_middle_classes.tutor_id')
    ->take($per_page);

    //figure out how to sort it by
    $sort_options = ['best_match' => 'Best Match', 'name' => 'Last Name: Ascending', 'proximity' => 'Proximity: Close to Far', 'rate' => 'Hourly Rate: Low to High', 'joined' => 'Member Since: Old to New', 'rating' => 'Rating: High to Low', 'schedule' => 'Schedule Match: Best to Worst'];


    $sort_by = 'best_match'; //default sort

    switch ($request->get('sort'))
    {

      case 'best_match':
        $search
        ->orderBy('classes_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'best_match';
        break;
      case 'name':
        $search
        ->orderBy('lname', 'asc')
        ->orderBy('fname', 'asc')
        ->orderBy('classes_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc');
        $sort_by = 'name';
        break;
      case 'proximity':
        $search
        ->orderBy('distance_match', 'desc')
        ->orderBy('classes_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'proximity';
        break;
      case 'schedule':
        $search
        ->orderBy('times_match', 'desc')
        ->orderBy('classes_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'schedule';
        break;
      case 'joined':
        $search
        ->orderBy('users.created_at', 'asc')
        ->orderBy('classes_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'joined';
        break;
      case 'rate':
        $search
        ->orderBy('tutors.rate', 'asc')
        ->orderBy('classes_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'rate';
        break;
      case 'rating':
        $search
        ->orderBy('avg_rating', 'desc')
        ->orderBy('classes_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'rating';
        break;
      default:
        $search
        ->orderBy('classes_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'best_match';
        break;
    }

    if ($request->get('page') > 1)
    {
      $search->skip(($request->get('page')-1)*$per_page);
    }
    $results = $search->get();


    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($results, $num_rows, $per_page, $request->get('page'));
    $paginator->setPath($request->url());
    $paginator->appends('sort', $sort_by);


    if (\Auth::check())
    {

      $tutor_contacts = \Auth::user()->tutor_contacts()->select('tutor_id')->get()->pluck('tutor_id')->toArray();
      $saved_tutors = \Auth::user()->saved_tutors()->join('users', 'tutor_id', '=', 'users.id')->get()->pluck('tutor_id')->toArray();
      return view('search/school/showschoolresults', ['results' => $results, 'num_results' => $num_rows, 'paginator' => $paginator, 'sort_options' => $sort_options,
       'sort_by' => $sort_by, 'num_classes' => $num_classes, 'num_availability' => $num_availability, 'tutor_contacts' => $tutor_contacts]);
    }
    else $saved_tutors = array();
    \Session::put('feedback_warning', "For the protection of our site's tutors, we are blocking most of the site's functionality including the ability to view their profile, see reviews, and contact them. Please <a href=\"".route('auth.login')."\">login/register</a>.");
    return view('search/showresultsplain', ['results' => $results, 'num_results' => $num_rows, 'paginator' => $paginator, 'sort_options' => $sort_options, 'sort_by' => $sort_by]);

  }
}
