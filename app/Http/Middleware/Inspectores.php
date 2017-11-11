<?php


namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

class Inspectores
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     protected $auth;
     public function __contructor(Guard $auth){
        $this->auth = $auth;
     }// constructor


    public function handle($request, Closure $next)
    {
      if (Auth::guard($this->auth)->check()) {
          if(Auth::guard($this->auth)->user()->state==1){
      switch (Auth::guard($this->auth)->user()->idrol) {
        case '1':
          # code...
          return redirect('admin');
          break;

        case '2':
      
           return redirect('jefat');
        break;

        case '3':
              # code...
             // return redirect('inspec');
        break;

        case '4':
                # code...
         return redirect('public');
                
        break;
        case '5':
                # code...
        return redirect('contra');
        default:
          # code...
          return redirect('login');
          break;
      }// fin del switch
      }else{
            return redirect('out');
      }
    }// fin del checkout
        return $next($request);
    }
}
