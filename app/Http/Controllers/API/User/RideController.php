<?php

namespace App\Http\Controllers\API\User;

use App\Driver;
use App\Payment;
use App\Ride;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class RideController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'location' => 'required',
            'destination' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        try {

            $ride = Ride::create([
                'location' => $request->location,
                'destination' => $request->destination,
                'date' => $request->date,
                'time' => $request->time,
                'rider_id' => $request->user,
                'driver_id' => $request->driver,
            ]);

            $driver = Driver::whereId($request->driver)->first();

            $amount = Setting::whereName($driver->car_type)->first();
//            dd($amount);
            $payment = Payment::create([
                'amount' => $amount->amount,
                'ride_id' => $ride->id,
                'rider_id' => $request->user,
                'driver_id' => $request->driver,
                'transaction_id' => Str::random(10),
            ]);
            if (!$payment) {
                throw new \Exception('Failed to create payment');
            }
        } catch (\Exception $e) {
        }
    }

    public function rateRide(Request $request)
    {
        $this->validate($request, [
            'rating' => 'required'
        ]);

        $rating = Ride::whereId($request->ride)->update([
            'rating' => $request->rating,
            'status' => 1
        ]);

//        Driver's ew rating
        $driver = Driver::whereId($request->driver)->first();
        $averageRatings = Ride::whereDriverId($request->driver)->average('rating');
        $driver->rating = round($averageRatings);
        $driver->save();
        return $rating;
    }

    public function cancelRide($id){
        Ride::whereId($id)->update([
            'status' => 2
        ]);
         Payment::whereRideId($id)->update([
             'status' => 2
         ]);
    }

    public function completeRide($id){
        Ride::whereId($id)->update([
            'status' => 1
        ]);
    }
}
