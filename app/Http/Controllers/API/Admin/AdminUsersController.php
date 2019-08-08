<?php

namespace App\Http\Controllers\API\Admin;

use App\Driver;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUsersController extends Controller
{
    public function totalRiders() {
        $riders = User::whereRole(0)->get();
        return count($riders);
    }

    public function totalDrivers() {
        $drivers = User::whereRole(2)->get();
        return count($drivers);
    }

    public function drivers() {
        $drivers = Driver::all();
        $users = User::whereRole(2)->get();
        return $drivers;
    }

    public function users() {
        $users = User::where('role', '!=', 1)->get();
        return $users;
    }

    public function status(Request $request,$id) {
        User::whereId($id)->update([
            'ban' => $request->status
        ]);
        return 'status updated';
    }

    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return 'User deleted successfully';
    }
    public function deleteDriver(Request $request, $id) {
        $user = Driver::findOrFail($id);
        $user->delete();
        return 'Driver deleted successfully';
    }

    public function driverStatus(Request $request, $id) {
        Driver::whereId($id)->update([
            'approved' => $request->status
        ]);
        return 'Status Updated';
    }

    public function driver($id) {
        return  Driver::findOrFail($id);
    }
}
