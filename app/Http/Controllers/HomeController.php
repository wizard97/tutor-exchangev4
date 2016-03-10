<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Statistic\Stat;
use App\Models\User\User;
use App\Models\Tutor\Tutor;

// Repositories
use App\Repositories\Messenger\Thread\ThreadRepository;

class HomeController extends Controller
{
  public function index(ThreadRepository $threadRepo)
  {
    Stat::incr_visitors();
    $stats = Stat::firstOrFail();
    $stats->std_members = User::where('account_type', 1)->count();
    $stats->tutor_members = User::where('account_type', '>=', 2)->count();
    $stats->active_tutors = Tutor::where('tutor_active', '1')->count();
    $stats->tutor_contacts = $threadRepo->countTutorContacts();

    return view('home')->with('stats', $stats);
  }
}
