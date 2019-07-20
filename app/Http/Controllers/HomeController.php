<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function registerRef($name) {

        $check = User::whereUsername($name)->first();
//        dd($check);
        if($check && $check->username != 'super-admin' && $check->username != 'admin') {
            return view('auth.registerRef', ['reflink' => $name]);
        }
        return redirect('/register');
    }

}
