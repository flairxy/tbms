<?php

namespace App\Http\Controllers\API\User;

use App\Driver;
use App\Payment;
use App\Ride;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function drivers()
    {
        $drivers = Driver::whereAvailable(1)->whereApproved(1)->get(['id', 'rating', 'user_id', 'car_type']);
        $rides = Ride::where('rating', '!=', null)->get();
        $users = User::whereRole(2)->get(['id', 'name']);
        return [
            'drivers' => $drivers,
            'users' => $users,
            'rides' => $rides
        ];
    }

    public function driver($id)
    {
        return Driver::whereUserId($id)->first();

    }

    public function availability(Request $request, $id)
    {
        return Driver::whereId($id)->update([
            'available' => $request->status
        ]);

    }

    public function updateDriver(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'passport' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'licence' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'licence_expiry' => 'required',
            'car_type' => 'required'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user = Driver::whereId($id)->first();
        $user->update([
            'car_type' => $request->car_type,
            'licence_expiry' => $request->licence_expiry
        ]);
        if ($request->hasFile('passport')) {
            $uploadedFile = $request->file('passport');
            $name = uniqid('driver', '_') . '.' . $uploadedFile->getClientOriginalExtension();
            $path = $uploadedFile->storePubliclyAs('public/passport/' . date('Y-W'), $name);

//            $user->image = $path;
            $user->update([
                'passport' => $path,
            ]);
        }
        if ($request->hasFile('licence')) {
            $uploadedFile = $request->file('licence');
            $name = uniqid('driver', '_') . '.' . $uploadedFile->getClientOriginalExtension();
            $path = $uploadedFile->storePubliclyAs('public/licence/' . date('Y-W'), $name);

//            $user->image = $path;
            $user->update([
                'licence' => $path
            ]);
        }
        $data['status'] = true;
        $data['message'] = 'Profile Update successful';
        return $data;

    }

    public function rides($id)
    {
        $rides = Ride::whereRiderId($id)->get();
        $drivers = User::get(['id', 'name']);
        return [
            'rides' => $rides,
            'drivers' => $drivers
        ];
    }

    public function driverRides($id)
    {
        $rides = Ride::whereDriverId($id)->get();
        $riders = User::get(['id', 'name']);
        return [
            'rides' => $rides,
            'riders' => $riders
        ];
    }

    public function pendingRides($id) {
        $rides = Ride::whereDriverId($id)->whereStatus(0)->get();
        return count($rides);
    }

    public function driverTotalRides($id) {
        return Ride::whereDriverId($id)->get();
    }
}
