<?php

namespace App\Http\Controllers\Account;

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

  public function editname(Request $request)
  {
    $this->validate($request, [
      'fname' => 'required|max:30|alpha',
      'lname' => 'required|max:30|alpha',
    ]);

    $user = \App\User::findOrFail($this->id);
    $user->fname = $request->input('fname');
    $user->lname = $request->input('lname');
    $user->save();

    \Session::flash('feedback_positive', 'You have successfully updated your name.');
    return back();
  }

  public function editemail(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email|max:255|unique:users',
    ]);

    $user = \App\User::findOrFail($this->id);
    $user->email = $request->input('email');
    $user->save();

    \Session::flash('feedback_positive', 'You have successfully updated your email address.');
    return back();
  }

  public function editaddress(Request $request)
  {
    $this->validate($request, [
      'address' => 'required'
    ]);

    $url = "https://maps.googleapis.com/maps/api/geocode/json?";

    $query = $url.http_build_query(['address' => $request->input('address'), 'key' => getenv('GOOGLE_API_KEY')]);
    $response = json_decode(file_get_contents($query));

    if(empty($response->results[0]))
    {
      \Session::flash('feedback_negative', 'We were unable to lookup your address.');
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

    $user = \App\User::findOrFail($this->id);
    $user->address = $response->results[0]->formatted_address;
    $user->zip_id = \App\Zip::where('zip_code', '=', $zip)->firstOrFail()->id;
    $user->lat = $response->results[0]->geometry->location->lat;
    $user->lon = $response->results[0]->geometry->location->lng;

    $user->save();

    \Session::flash('feedback_positive', 'You have successfully updated your address.');
    return back();
  }
/* no longer needed
  public function editzip(Request $request)
  {
    $this->validate($request, [
      'zip'   => 'required|digits:5|numeric|exists:zips,zip_code',
    ]);

    $user = \App\User::findOrFail($this->id);
    $user->zip_id = \App\Zip::where('zip_code', '=', $request->input('zip'))->firstOrFail()->id;
    $user->save();

    \Session::flash('feedback_positive', 'You have successfully updated your Zip code.');
    return back();
  }
*/
  public function editaccounttype(Request $request)
  {
    $this->validate($request, [
      'account_type' => 'required|integer|min:1|max:3',
    ]);
    $user = \App\User::findOrFail($this->id);

    if ($user->account_type == $request->input('account_type'))
    {
      \Session::flash('feedback_negative', 'You are already this account type');
      return back();
    }

    //if downgrading from tutor
    if ($request->input('account_type') == 1)
    {
      //delete tutors classes
      \App\TutorLevel::where('user_id', $user->id)->delete();
      //delete any refrence to SavedTutor
      \App\SavedTutor::where('tutor_id', $user->id)->delete();
      $user->tutor()->delete();
      $user->account_type = $request->input('account_type');
      $user->save();
      \Session::flash('feedback_positive', 'You have successfully downgraded your account, your tutoring info has been deleted.');
    }
    //if upgrading from standard user
    elseif($user->account_type == 1)
    {
      $user->tutor()->firstOrCreate([]);
      $user->account_type = $request->input('account_type');
      $user->save();
      \Session::flash('feedback_positive', 'You have successfully upgraded your account.');
    }
    //if only changing tutoring type
    else
    {
      $user->account_type = $request->input('account_type');
      $user->save();
      \Session::flash('feedback_positive', 'You have successfully changed your account type.');
    }

    return back();
  }

  public function editpassword(Request $request)
  {
    $this->validate($request, [
      'password' => 'required|confirmed|min:6',
    ]);

    $user = \App\User::findOrFail($this->id);
    $user->password = bcrypt($request->input('password'));
    $user->save();

    \Session::flash('feedback_positive', 'You have successfully changed your password.');
    return back();
  }
}
