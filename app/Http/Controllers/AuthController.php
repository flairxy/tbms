<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Referral;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function registerAsDriver(Request $request) {

        $this->validator($request->all())->validate();
        try {
            $data = $request->all();
            $user = User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role'=> 2
            ]);

            Driver::create([
                'user_id' => $user->id,
                'registration_no' => 'UNN/TB/' . $user->id . random_int(10, 1000)
            ]);
        } catch (\Exception $e) {
        }
        return redirect('/login')->with('status', 'Registration Successful. Login to continue');
    }
}
