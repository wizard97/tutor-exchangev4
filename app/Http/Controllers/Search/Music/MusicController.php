<?php

namespace App\Http\Controllers\Search\Music;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MusicController extends Controller
{
  //search form for instrument
  public function index()
  {
    $instruments = \App\Music::leftjoin('tutor_music', 'tutor_music.music_id', '=', 'music.id')
    ->leftjoin('tutors', 'tutors.user_id', '=', 'tutor_music.tutor_id')
    ->groupBy('music.id')
    ->select('music.*', \DB::raw('SUM(CASE WHEN tutors.tutor_active = 1 THEN 1 ELSE 0 END) AS num_tutors'))
    ->get();
    return view('search/music/index')->with('instruments', $instruments);
  }

  public function searchformsubmit(Request $request)
  {
    if(\Auth::check())
    {
        $this->validate($request, [
        'instrument' => 'required|exists:music,id',
        'years_playing' => 'required|numeric|min:0',
        'school_type' => 'required|in:middle,high',
        'tutor_type' => 'required|in:standard,professional',
        'start_rate' => 'numeric|between:0,200',
        'end_rate' => 'numeric|between:0,200',
        'max_dist' => 'numeric|between:1,200',
        ]);
    }
    else {
      $this->validate($request, [
      'instrument' => 'required|exists:music,id',
      'years_playing' => 'required|numeric|min:0',
      'zip' => 'required|digits:5|numeric|exists:zips,zip_code',
      'school_type' => 'required|in:middle,high',
      'tutor_type' => 'required|in:standard,professional',
      'start_rate' => 'numeric|between:0,200',
      'end_rate' => 'numeric|between:0,200',
      'max_dist' => 'numeric|between:1,200',
      ]);
    }


    $input = $request->all();
    //flash form data into session
    $request->session()->forget('music_search_inputs');
    $request->session()->put('music_search_inputs', $input);

    //high school or above for standard tutors
    if ($request->input('school_type') == 'high' && $request->input('tutor_type') == 'standard')
    {
      return redirect(route('music.showresults'));
    }
    else //middle school or below
    {
      return redirect(route('music.showresults'));
    }

  }

  public function showresults(Request $request)
  {
    $form_inputs = $request->session()->get('music_search_inputs');
    if(empty($form_inputs)) return redirect()->route('music.index');
    $inst_id = $form_inputs['instrument'];

    $search = \App\Music::findOrFail($inst_id)->tutors();

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
    if (!empty($hs_id)) $search->where('music.id', '=', $inst_id);


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
          $time_array[] = "(({$time_alias[$day]} BETWEEN tutors.{$day}1_start AND tutors.{$day}1_end) OR ({$time_alias[$day]} BETWEEN tutors.{$day}2_start AND tutors.{$day}2_end))";
        }
      }
    });

    if(isset($max_dist))
    {
      $search
      ->whereRaw("3959*ACOS(COS(RADIANS(users.lat)) * COS(RADIANS(?)) * COS(RADIANS(users.lon) - RADIANS(?)) + SIN(RADIANS(users.lat)) * SIN(RADIANS(?))) <= ?", [$u_lat, $u_lon, $u_lat, $max_dist])
      ->whereRaw("users.lat BETWEEN (? - (? / 69.0)) AND (? + (? / 69.0))", [$u_lat, $max_dist, $u_lat, $max_dist])
      ->whereRaw("users.lon BETWEEN (? - (? / (69.0 * COS(RADIANS(?))))) AND (? + (? / (69.0 * COS(RADIANS(?)))))", [$u_lon, $max_dist, $u_lon, $u_lon, $max_dist, $u_lon]);
    }


    //finish building search
    $search
    ->join('music', 'music.id', '=', 'tutor_music.music_id')
    ->join('users', 'users.id', '=', 'tutor_music.tutor_id')
    ->leftjoin('grades', 'tutors.grade', '=', 'grades.id')
    ->join('zips', 'users.zip_id', '=', 'zips.id')
    ->where('account_type', '>=', '2')
    ->where('tutors.tutor_active', '=', '1')
    ->where('tutors.profile_expiration', '>=', date('Y-m-d H:i:s'))
    ->wherePivot('upto_years', '>=', $form_inputs['years_playing']);

    //this is all we need for row count
    $num_rows = $search->count();

    //add additional stuff for full search
    if(!empty($time_array))
    {
      $num_availability = count($time_array);
      $time_select = "ROUND(((".implode(' + ', $time_array).")/".count($time_array).")*100, 0) AS 'times_match'";
      $time_select2 = "(".implode(' + ', $time_array).") AS availability_count";
    } else {
      $num_availability = 0;
      $time_select = "100 AS 'times_match'";
      $time_select2 = "0 AS availability_count";
    }


    $dist_select = sprintf("ROUND(3959*ACOS(COS(RADIANS(users.lat)) * COS(RADIANS('%s')) * COS(RADIANS(users.lon) - RADIANS('%s')) + SIN(RADIANS(users.lat)) * SIN(RADIANS('%s'))), 0) AS '%s'", $u_lat, $u_lon, $u_lat, 'distance');

    if(isset($max_dist))
    {
      $dist_select2 = sprintf("ROUND(((%s - 3959*ACOS(COS(RADIANS(users.lat)) * COS(RADIANS('%s')) * COS(RADIANS(users.lon) - RADIANS('%s')) + SIN(RADIANS(users.lat)) * SIN(RADIANS('%s'))))/%s)*100, 0) as %s", escape_sql($max_dist), $u_lat, $u_lon, $u_lat, escape_sql($max_dist), 'distance_match');
    } else {
      $dist_select2 = "100 AS 'distance_match'";
    }

    $per_page = 15;

    $search
    ->leftjoin('reviews', 'reviews.tutor_id', '=', 'tutor_music.tutor_id')
    ->select(\DB::raw($dist_select), \DB::raw($dist_select2), \DB::raw($time_select), \DB::raw($time_select2), \DB::raw('AVG(reviews.rating) AS avg_rating'), 'users.account_type', 'tutor_music.tutor_id', 'users.id',
    'users.fname', 'users.lname', 'users.last_login', 'users.created_at','tutors.*', 'grades.*', 'zips.*')
    ->groupBy('tutor_music.tutor_id')
    ->take($per_page);

    //figure out how to sort it by
    $sort_options = ['best_match' => 'Best Match', 'experience' => 'Years of Experience: Descending', 'name' => 'Last Name: Ascending', 'proximity' => 'Proximity: Close to Far', 'rate' => 'Hourly Rate: Low to High', 'joined' => 'Member Since: Old to New', 'rating' => 'Rating: High to Low', 'schedule' => 'Schedule Match: Best to Worst'];


    $sort_by = 'best_match'; //default sort

    switch ($request->get('sort'))
    {

      case 'best_match':
        $search
        ->orderBy('upto_years', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'best_match';
        break;
      case 'experience':
        $search
        ->orderBy('years_experiance', 'desc')
        ->orderBy('upto_years', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'experience';
        break;
      case 'name':
        $search
        ->orderBy('lname', 'asc')
        ->orderBy('fname', 'asc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc');
        $sort_by = 'name';
        break;
      case 'proximity':
        $search
        ->orderBy('distance_match', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'proximity';
        break;
      case 'joined':
        $search
        ->orderBy('users.created_at', 'asc')
        ->orderBy('upto_years', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'joined';
        break;
      case 'schedule':
        $search
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'schedule';
        break;
      case 'rate':
        $search
        ->orderBy('tutors.rate', 'asc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'rate';
        break;
      case 'rating':
        $search
        ->orderBy('avg_rating', 'desc')
        ->orderBy('times_match', 'desc')
        ->orderBy('distance_match', 'desc')
        ->orderBy('lname', 'asc');
        $sort_by = 'rating';
        break;
      default:
        $search
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
    //return var_dump($paginator->toArray());

    if (\Auth::check())
    {
      $tutor_contacts = \Auth::user()->tutor_contacts()->select('tutor_id')->get()->pluck('tutor_id')->toArray();
      $saved_tutors = \Auth::user()->saved_tutors()->join('users', 'tutor_id', '=', 'users.id')->get()->pluck('tutor_id')->toArray();
      return view('search/music/showmusicresults', ['results' => $results, 'num_results' => $num_rows, 'paginator' => $paginator, 'sort_options' => $sort_options,
       'sort_by' => $sort_by, 'num_availability' => $num_availability, 'tutor_contacts' => $tutor_contacts]);
    }
    else $saved_tutors = array();
    \Session::put('feedback_warning', "For the protection of our site's tutors, we are blocking most of the site's functionality including the ability to view their profile, see reviews, and contact them. Please <a href=\"".route('auth.login')."\">login/register</a>.");
    return view('search/showresultsplain', ['results' => $results, 'num_results' => $num_rows, 'paginator' => $paginator, 'sort_options' => $sort_options, 'sort_by' => $sort_by]);


  }

}
