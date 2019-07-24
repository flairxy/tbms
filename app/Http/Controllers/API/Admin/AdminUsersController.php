<?php

namespace App\Http\Controllers\API\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUsersController extends Controller
{
    public function index() {
        $users = User::whereRole(0)->get();
        return response($users);
    }
    public function admins() {
        $this->authorize('isSA');
        $users = User::whereRole(1)->get();
        return response($users);
    }
    public function roles() {
        $roles = Role::all();
        return response($roles);
    }

    public function adminRoles($id) {
        $this->authorize('isSA');
        $user = User::findOrFail($id);
        $roles = $user->roles()->get();
        if($roles) {
            foreach ($roles as $role) {
                $name[] = $role->slug;
            }
            return Response($name);
        }
    }


    public function create(Request $request) {
        $this->validator($request->all())->validate();
        $data = $request->all();

        $this->authorize('isSuperAdmin');

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 1
        ]);
        $role = Role::findOrFail($request->role);
        $user->roles()->attach($role);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }
}
