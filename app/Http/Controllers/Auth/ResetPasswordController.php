<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    protected function redirectTo() {

        if (Auth::user()->role == '2') {
            session()->flash('success', 'Login Successful');
            $this->redirectTo = '/driver/dashboard';
            return $this->redirectTo;
        }

        if (Auth::user()->role == '0') {
            session()->flash('success', 'Login Successful');
            $this->redirectTo = '/user/dashboard';
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
        $this->middleware('guest');
    }
}
