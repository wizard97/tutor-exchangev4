<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    if (\Auth::check()) {
    $this->id = \Auth::user()->id;
    }
  }

  public function index()
  {

    return view('account/settings/index');
  }

}
