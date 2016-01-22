<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;



class ProposalController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
      $g = \Geocoder::geocode('909 talamore drive ambler');
      echo sprintf("%s %s, %s, %s %s", $g->getStreetNumber(), $g->getStreetName(),
          $g->getCity(), $g->getRegionCode(), $g->getZipCode());

      //var_dump($g->first()->getLatitude());
    }
}
