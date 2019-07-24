<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
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
           if (Auth::user()->role == '0') {

               return $next($request);
           }
           return abort(404);
       }
        return redirect()->route('login');
    }
}
