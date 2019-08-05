<?php

namespace App\Http\Controllers\API\Admin;

use App\Driver;
use App\Ride;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRideController extends Controller
{
    public function allRides() {
        $rides = Ride::all();
        $users= User::all();
        $drivers = Driver::all();
        return [
            'users' => $users,
            'rides' => $rides,
            'drivers' => $drivers,
        ];
    }
}
