<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;


class AuthController extends Controller {

  public function __construct()
  {
    $this->middleware('guest', ['except' => ['confirm', 'getLogout']]);
  }

    public function getRegister()
    {
      return view('auth/register');
    }


    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
                    'fname' => 'required|max:30|alpha',
                    'lname' => 'required|max:30|alpha',
                    'address' => 'required|string',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
                    'account_type' => 'required|integer|min:1|max:3',
                    'terms_conditions' => 'required|accepted'
                ]);

        if($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation', 'terms_conditions'));
        }

        $confirmation_code = str_random(30);


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

        $zip_model = \App\Zip::where('zip_code', '=', $zip)->firstOrFail();


        $new_user = $zip_model->users()->create([
          'fname' => $request->input('fname'),
          'lname' => $request->input('lname'),
          'address' => $response->results[0]->formatted_address,
          'lat' => $response->results[0]->geometry->location->lat,
          'lon' => $response->results[0]->geometry->location->lng,
          'email' => $request->input('email'),
          'password' => bcrypt($request->input('password')),
          'account_type' => $request->input('account_type'),
          'activation_hash' => $confirmation_code,
          'user_active' => 0
        ]);

        //if a tutor, create their profile
        if($request->input('account_type') > 1)
        {
          $new_user->tutor()->firstOrCreate([]);
        }
        $inputs = $request->all();
        \Mail::queue('emails.verify', array('confirmation_code' => $confirmation_code, 'name' => $request->input('fname').' '.$request->input('lname')), function($message) use ($inputs) {
            $message->to($inputs['email'], $inputs['fname'].' '.$inputs['lname'])->subject('Activate your account')->from('no-reply@lextutorexchange.com','Lexington Tutor Exchange');
        });
        \Session::flash('feedback_positive', 'Thanks for signing up! Please check your email for an activation link to activate your account.');

        return redirect('home');
    }

    public function confirm($confirmation_code)
    {
       if( ! $confirmation_code)
       {
         return redirect('auth/login');
       }

       $user = User::where('activation_hash', $confirmation_code)->first();

       if ( ! $user)
       {
         \Session::flash('feedback_negative', "That was not a valid activation link, are you sure you didn't already activate your account?");
         return redirect('auth/login');
       }

       $user->user_active = 1;
       $user->activation_hash = null;
       $user->save();

       \Session::flash('feedback_positive', 'You have successfully verified your account.');

       return redirect('auth/login');
   }

   public function getLogin()
   {
     return view('auth/login');
   }


   public function postLogin()
  {
      $rules = [
          'email' => 'required|exists:users',
          'password' => 'required'
      ];

      $input = \Input::only('email', 'password');

      $validator = \Validator::make($input, $rules);

      if($validator->fails())
      {
          return \Redirect::back()->withInput()->withErrors($validator);
      }

      $credentials = [
          'email' => \Input::get('email'),
          'password' => \Input::get('password'),
          'user_active' => 1
      ];

      if (!Auth::attempt($credentials, \Input::get('remember')))
      {
          return \Redirect::back()
              ->withInput()
              ->withErrors([
                  'credentials' => 'We were unable to sign you in. Please double check your credentials and make sure you already activated your account.'
              ]);
      }
      $user = Auth::user();
      $model = \App\User::findOrFail($user->id);
      $model->last_login = date('Y-m-d H:i:s');
      $model->save();

      \Session::flash('feedback_positive', 'Welcome back '.$user->fname.' '.$user->lname.'!');
      if ($user->account_type > 1) return redirect()->intended(route('tutoring.dashboard'));
      else return redirect()->intended('home');
  }

  public function getLogout()
  {
    \Session::flush();
    Auth::logout();
    \Session::flash('feedback_positive', 'You have been logged out.');
    return redirect('home');
  }
}
