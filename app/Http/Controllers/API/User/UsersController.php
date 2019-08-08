<?php

namespace App\Http\Controllers\API\User;

use App\Driver;
use App\Payment;
use App\Ride;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Image;

class UsersController extends Controller
{
    public function drivers()
    {
        $drivers = Driver::whereAvailable(1)->whereApproved(1)->get(['id', 'rating', 'user_id', 'car_type', 'passport']);
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
        if ($request->hasFile('passport')) {
            $image = $request->file('passport');
            $filename = 'driver_'.$user->user_id. '_passport.' . $image->getClientOriginalExtension();
            $location = 'files/passport/' . $filename;
            $user->passport = $filename;

            $path = './files/passport/';
            $link = $path . $user->passport;
            if (file_exists($link)) {
                unlink($link);
            }
            //install image intervention to use this Image::
            Image::make($image)->resize(400, 400)->save($location);
        }
        if ($request->hasFile('licence')) {
            $image = $request->file('licence');
            $filename = 'driver_'.$user->user_id. '_licence.' . $image->getClientOriginalExtension();
            $location = 'files/licence/' . $filename;
            $user->licence = $filename;

            $path = './files/licence/';
            $link = $path . $user->licence;
            if (file_exists($link)) {
                unlink($link);
            }
            //install image intervention to use this Image::
            Image::make($image)->resize(500, 500)->save($location);
        }
        $user->car_type = $request->car_type;
        $user->licence_expiry = $request->licence_expiry;
        $user->save();
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
