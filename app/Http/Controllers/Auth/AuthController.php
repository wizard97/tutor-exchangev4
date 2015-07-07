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


    public function store()
    {

        $validator = \Validator::make(\Input::all(), [
                    'fname' => 'required|max:30|alpha',
                    'lname' => 'required|max:30|alpha',
                    'address' => 'required',
                    'zip'   => 'required|digits:5|numeric',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
                    'account_type' => 'required|integer|min:1|max:3',
                    'terms_conditions' => 'required|accepted'
                ]);

        if($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput(\Input::except('password', 'password_confirmation', 'terms_conditions'));
        }

        $confirmation_code = str_random(30);

        $new_user = User::create([
          'fname' => \Input::get('fname'),
          'lname' => \Input::get('lname'),
          'address' => \Input::get('address'),
          'zip' => \Input::get('zip'),
            'email' => \Input::get('email'),
            'password' => bcrypt(\Input::get('password')),
            'account_type' => \Input::get('account_type'),
            'activation_hash' => $confirmation_code,
            'user_active' => 0
        ]);

        //if a tutor, create their profile
        if(\Input::get('account_type') > 1)
        {
          $new_user->tutor()->firstOrCreate([]);
        }
        \Mail::send('emails.verify', array('confirmation_code' => $confirmation_code, 'name' => \Input::get('fname').' '.\Input::get('lname')), function($message) {
            $message->to(\Input::get('email'), \Input::get('fname').' '.\Input::get('lname'))->subject('Activate your account')->from('no-reply@lextutorexchange.com','Lexington Tutor Exchange');
        });
        \Session::flash('feedback_positive', 'Thanks for signing up! Please check your email.');

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
      if ($user->account_type > 1) return redirect()->intended(route('tutorDashboard'));
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
