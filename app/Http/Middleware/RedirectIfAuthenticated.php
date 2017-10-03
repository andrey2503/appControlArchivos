<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // return redirect('admin');
        switch (Auth::guard($guard)->user()->idrol) {
          case '1':
            # code...
              return redirect('admin');
            break;

        case '2':
              # code...
         return redirect('jefat');
              
            break;

        case '3':
                # code...
               return redirect('inspec');
            break;

          default:
            # code...
            return redirect('login');
            break;
        }// fin del switch

        }// fin del if 

        return $next($request);
    }
}
