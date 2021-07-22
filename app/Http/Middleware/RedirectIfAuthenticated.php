<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class RedirectIfAuthenticated {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  ...$guards
   * @return mixed
   */
  public function handle(Request $request, Closure $next, ...$guards) {


    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard)
    {
      if (Auth::guard($guard)->check())
      {
        $User = DB::table('users')->where('id', Auth::id())->first();
        Cookie::queue(Cookie::forever('fio', $User->imya . " " . $User->familia));
        return redirect('cabinet');
      }
    }

    return $next($request);
  }

}
