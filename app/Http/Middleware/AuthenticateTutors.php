<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateTutors
{

  public function __construct(Guard $auth)
  {
      $this->auth = $auth;
  }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if ($this->auth->guest()) {
          if ($request->ajax()) {
              return response('Unauthorized.', 401);
          } else {
              return redirect()->guest(route('auth.login'));
          }
      }
      elseif($this->auth->user()->account_type < 2)
      {
        \Session::put('feedback_negative', "You must be a tutor to view that page, you can change your account type here.");
        return redirect()->guest(route('accountsettings.index'));
      }
      return $next($request);
  }
}
