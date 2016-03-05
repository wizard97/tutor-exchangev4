<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Proposals\School\SchoolProposalRepository;
use App\Http\Requests\ProposeSchoolRequest;

class ProposalController extends Controller
{
  public function __construct()
  {

  }

  public function index()
  {
    /*
    $g = \Geocoder::geocode('909 talamore drive ambler');
    echo sprintf("%s %s, %s, %s %s", $g->getStreetNumber(), $g->getStreetName(),
    $g->getCity(), $g->getRegionCode(), $g->getZipCode());
    */

    //var_dump($g->first()->getLatitude());
    return view('/account/proposals/index');
  }

  public function getsubmitclass() //submit class view
  {
    return view('/account/proposals/submitclass');
  }
  public function getSubmitSchool() //submit school view
  {
    return view('/account/proposals/submitschool');
  }

  public function postSubmitSchool(ProposeSchoolRequest $request, SchoolProposalRepository $spr)
  {
    try
    {
      $spr->create($request->all(), \Auth::id()); //try to make a proposal
    }
    catch(\Exception $e)
    {
      $error = $e->getMessage();
      $request->session()->put('feedback_negative', "An unexpected error occured.");
      return back();
    }
    $request->session()->put('feedback_positive', 'Your proposal was recorded.');
    return back();
  }

  public function getsubmitsubject() //submit subject view
  {
    return view('/account/proposals/submitsubject');
  }
}
