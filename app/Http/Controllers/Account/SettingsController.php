<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User\User;
use App\Models\Tutor\Tutor;
use App\Models\Zip\Zip;

class SettingsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    if (\Auth::check()) {
      $this->id = \Auth::user()->id;
    }
  }

  public function index() //main settings view
  {
    return view('account/settings/index');
  }

  public function editname(Request $request)
  {
    $this->validate($request, [ //verify form validity
      'fname' => 'required|max:30|alpha',
      'lname' => 'required|max:30|alpha',
    ]);

    $user = User::findOrFail($this->id); //store user object
    $user->fname = $request->input('fname'); //set name
    $user->lname = $request->input('lname');
    $user->save(); //update db

    \Session::put('feedback_positive', 'You have successfully updated your name.');
    return back();
  }

  public function editemail(Request $request)
  {
    $this->validate($request, [ //verify form validity
      'email' => 'required|email|max:255|unique:users',
    ]);

    $user = User::findOrFail($this->id); //store user object
    $user->email = $request->input('email'); //set email
    $user->save(); //update db

    \Session::put('feedback_positive', 'You have successfully updated your email address.');
    return back();
  }

  public function editaddress(Request $request)
  {
    $this->validate($request, [ //verify form validity
      'address' => 'required'
    ]);

    $url = "https://maps.googleapis.com/maps/api/geocode/json?";

    $query = $url.http_build_query(['address' => $request->input('address'), 'key' => getenv('GOOGLE_API_KEY')]);
    $response = json_decode(file_get_contents($query));

    if(empty($response->results[0])) //ensure address exists
    {
      \Session::put('feedback_negative', 'We were unable to lookup your address.');
      return back();
    }

    $zip = '';
    foreach($response->results[0]->address_components as $comp)
    {
      //parse the array
      if($comp->types[0] == 'postal_code')
      {
        $zip = $comp->short_name;
      }
    }

    //return var_dump($response->results[0]->geometry->location->lat);

    $user = User::findOrFail($this->id); //store user object
    $user->address = $response->results[0]->formatted_address; //store address
    $user->zip_id = Zip::where('zip_code', '=', $zip)->firstOrFail()->id; //"id
    $user->lat = $response->results[0]->geometry->location->lat; //store location
    $user->lon = $response->results[0]->geometry->location->lng;
    $user->save(); //update db
    \Session::put('feedback_positive', 'You have successfully updated your address.');
    return back();
  }
  public function editaccounttype(Request $request)
  {
    $this->validate($request, [ //verify form validity
      'account_type' => 'required|integer|min:1|max:3',
    ]);
    $user = User::findOrFail($this->id); //store user object

    if ($user->account_type == $request->input('account_type'))
    {
      \Session::put('feedback_negative', 'You are already this account type');
      return back();
    }

    //if downgrading from tutor
    if ($request->input('account_type') == 1)
    {
      //delete tutors classes
      $tutor = Tutor::findOrFail($this->id); //store tutor object
      $tutor->levels()->detach(); //remove tutorlevel pivottable entry
      $tutor->middle_classes()->detach(); //remove tutormiddleschool class pivot entry
      $tutor->music()->detach(); //remove music pivottable entry
      $tutor->schools()->detach(); //remove tutorschool pivottable entry
      $tutor->tutor_active = 0; //deactivate tutoring
      $tutor->save(); //update db
      //delete any refrence to SavedTutor
      $tutor->user_saves()->detach(); //remove from users' saved tutors
      $user->account_type = $request->input('account_type');
      $user->save(); //update db
      \Session::put('feedback_positive', 'You have successfully downgraded your account, your tutoring info has been deleted.');
    }
    //if upgrading from standard user
    elseif($user->account_type == 1)
    {
      $tutor = $user->tutor()->firstOrCreate([]); //set type
      $user->account_type = $request->input('account_type');
      $user->save(); //update db


      \Session::put('feedback_positive', 'You have successfully upgraded your account.');
    }
    //if only changing tutoring type
    else
    {
      $user->account_type = $request->input('account_type'); //set type
      $user->save(); //update db
      \Session::put('feedback_positive', 'You have successfully changed your account type.');
    }

    return back();
  }

  public function editpassword(Request $request)
  {
    $this->validate($request, [ //verify form validity
      'password' => 'required|confirmed|min:6',
    ]);

    $user = User::findOrFail($this->id); //store user object
    $user->password = bcrypt($request->input('password')); //create hash
    $user->save(); //update db

    \Session::put('feedback_positive', 'You have successfully changed your password.');
    return back();
  }
}
