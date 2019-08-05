<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    protected function redirectTo() {

        if (Auth::user()->role == '0') {
            session()->flash('success', 'Login Successful');
            $this->redirectTo = '/user/dashboard';
            return $this->redirectTo;
        }
        if (Auth::user()->role == '2') {
            session()->flash('success', 'Login Successful');
            $this->redirectTo = '/driver/dashboard';
            return $this->redirectTo;
        }
        session()->flash('success', 'Login Successful');
        $this->redirectTo = '/management/dashboard';
        return $this->redirectTo;
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
