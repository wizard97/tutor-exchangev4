<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Stat;
use App\User;

class HomeController extends Controller
{
  public function index()
  {
    \App\Stat::incr_visitors()
    $stats = Stat::firstOrFail();
    $stats->std_members = User::where('account_type', 1)->count();
    $stats->tutor_members = User::where('account_type', '>=', 2)->count();
    $stats->active_tutors = \App\Tutor::where('tutor_active', '1')->count();
    return view('home')->with('stats', $stats);
  }
}
