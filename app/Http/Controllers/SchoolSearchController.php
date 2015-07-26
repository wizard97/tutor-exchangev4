<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SchoolSearchController extends Controller
{

  public function index()
  {
    return view('search/school/index');
  }

  public function query($query)
  {
    $keys = preg_split("/[\s,]+/", trim(urldecode($query)));
    $num_keys = count($keys);
    $results_count = array();

    $search = \App\School::join('zips', 'schools.zip_code', '=', 'zips.zip_code');
    //make queries more complex until we stop getting results, then back up one
    for ($i = 0; $i < $num_keys; $i++)
    {
        $previous = $search;

        $search = $search->where(function ($query) use ($keys, $i){
          $query->orWhere('school_name', 'LIKE', '%'.$keys[$i].'%')
          ->orWhere('schools.zip_code', 'LIKE', '%'.$keys[$i].'%')
          ->orWhere('zips.city', 'LIKE', '%'.$keys[$i].'%')
          ->orWhere('zips.state_prefix', 'LIKE', '%'.$keys[$i].'%');
        });

          if ($search->count() == 0) break;
    }
    $matches = $previous->select('*', \DB::raw("CONCAT_WS(', ', school_name, CONCAT(UCASE(LEFT(city, 1)),LCASE(SUBSTRING(city, 2))), CONCAT_WS(' ',state_prefix, schools.zip_code)) as response"))
    ->take(10)
    ->get();
/*
    $matches = \App\School::join('zips', 'schools.zip_code', '=', 'zips.zip_code')
    ->orWhere('school_name', 'LIKE', '%'.$decoded.'%')
    ->orWhere('schools.zip_code', 'LIKE', '%'.$decoded.'%')
    ->orWhere('zips.city', 'LIKE', '%'.$decoded.'%')
    ->select('*', \DB::raw("CONCAT_WS(', ', school_name, CONCAT(UCASE(LEFT(city, 1)),LCASE(SUBSTRING(city, 2))), CONCAT_WS(' ',state_prefix, schools.zip_code)) as response"))
    ->take(10)
    ->get();
    */
    return $matches->toJson();
  }


  public function classes()
  {
    //make sure it has at elast one level
    $classes = \App\SchoolClass::orderBy('class_order', 'asc')->orderBy('class_name', 'asc')->get();
    $levels = \App\Level::orderBy('level_num', 'desc')->get()->groupBy('class_id');
  //  $classes->merge($levels);
    $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
    $grades = \App\Grade::all();

    \JavaScript::put([
    'classes' => $classes,
    'levels' => $levels,
    ]);

    return view('search/school/classes')->with('classes', $classes)->with('subjects', $subjects)->with('grades', $grades);
  }
}
