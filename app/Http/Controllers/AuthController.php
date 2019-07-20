<?php

namespace App\Http\Controllers;

use App\Account;
use App\Referral;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index() {
        return view('auth.auth');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function registerWithReflin(Request $request) {

        $this->validator($request->all())->validate();
        $data = $request->all();
        dd($data);
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Account::create([
            'user_id' => $user->id
        ]);

        if($data['reflink']) {
            $parent = User::whereUsername($data['reflink'])->first();
            if ($parent) {
                Referral::create([
                    'user_id' => $user->id,
                    'parent_id' => $parent->id,
                    'parent_link' => $parent->username,
                ]);
            }
        }
        $request->session()->put('success', 'Registration Successful. Login to continue');
        return redirect('/login')->with('status', 'Registration Successful. Login to continue');
    }
}
