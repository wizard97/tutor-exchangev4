<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UpdateUser
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
      if ($this->auth->check() && empty($this->auth->user()->address) && $request->url() != route('accountsettings.index') && $request->method() != 'POST'
        && $request->url() != route('auth.logout') )
      {
        \Session::put('feedback_warning', "Welcome to version 4.x! First we need you to update your address to help with calculating distances. It will be kept private.");
        return redirect()->route('accountsettings.index');
      }
      else
      {
        return $next($request);
      }
  }

}
