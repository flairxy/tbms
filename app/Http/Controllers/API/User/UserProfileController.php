<?php

namespace App\Http\Controllers\API\User;

use App\Account;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function getAccounts()
    {
        $accounts = Account::all();
        return response($accounts);
    }

    public function balance($id)
    {
        $account = Account::whereUserId($id)->first();
        return response($account);
    }

    public function updatePassword(Request $request)
    {
        Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed|max:255'
        ])->validate();

        $user = User::findOrFail($request->user);
        $user->password = Hash::make($request->password);
        $user->save();
        return response([
            'status' => 'success',
            'message' => 'Password update successful'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        Validator::make($request->all(), [
            'status' => 'required'
        ])->validate();

        $this->authorize('isSuperAdmin');

        $user = User::findOrFail($id);
        $user->ban = $request->status;
        $user->save();
        return response([
            'status' => 'success',
            'message' => 'Status update successful'
        ]);
    }
    public function updateAdminStatus(Request $request, $id)
    {
        Validator::make($request->all(), [
            'role' => 'required'
        ])->validate();

        $this->authorize('isSuperAdmin');

        $role = \App\Role::findOrFail($request->role);
        $user = User::findOrFail($id);
        $user->save();
        $user->roles()->sync($role);
        return response([
            'status' => 'success',
            'message' => 'Status update successful'
        ]);
    }

    public function deleteUser($id)
    {
        $this->authorize('isSuperAdmin');

        $user = User::findOrFail($id);
        $user->delete();
        return response([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }
}
