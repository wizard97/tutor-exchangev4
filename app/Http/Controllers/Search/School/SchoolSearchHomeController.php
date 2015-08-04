<?php

namespace App\Http\Controllers\Search\School;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SchoolSearchHomeController extends Controller
{
  //school search form
  public function searchform()
  {
    return view('search/school/searchform');
  }

  public function searchformsubmit(Request $request)
  {
    $this->validate($request, [
    'zip' => 'required|digits:5|numeric|exists:zips,zip_code',
    'school_type' => 'required|in:middle,high',
    'tutor_type' => 'required|in:standard,professional',
    'start_rate' => 'numeric|between:0,200',
    'end_rate' => 'numeric|between:0,200',
    ]);

    $input = $request->all();
    //flash form data into session
    $request->session()->forget('school_search_inputs');
    $request->session()->put('school_search_inputs', $input);

    //high school or above for standard tutors
    if ($request->input('school_type') == 'high' && $request->input('tutor_type') == 'standard')
    {
      return redirect(route('hs.index'));
    }
    else //middle school or below
    {
      return redirect(route('hs.classes'));
    }
    return view('search/school/searchform');
  }

}
