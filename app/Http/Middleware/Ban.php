<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Ban
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if( Auth::check()) {
//           $user = $request->user();
           if (Auth::user()->ban == '0') {

               return $next($request);
           }
           Auth::logout();
           return redirect('/login')->with('status', 'This account has been suspended. Kindly contact support');
       }
        return redirect()->route('login');
    }
}
