<?php

namespace App\Http\Controllers\API\Admin;

use App\Driver;
use App\Payment;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPaymentController extends Controller
{
    public function allPayments()
    {
        return Payment::whereStatus(1)->sum('amount');
    }

    public function transactions()
    {
        $payments = Payment::all();
        $users = User::all();
        $driver = Driver::all();

        return [
            'payments' => $payments,
            'users' => $users,
            'drivers' => $driver
        ];
    }

    public function create(Request $request)
    {

        $this->validate($request, [
            'value' => 'required|max:255',
            'name' => 'required'
        ]);

        $ref = Setting::whereName($request->name)->first();
        if (!$ref) {
            $setting = new Setting();
            $setting->name = $request->name;
            $setting->amount = $request->value;
            $setting->save();
            return response('Setting successfully');
        }
        return Setting::whereName($request->name)->update([
            'value' => $request->value
        ]);
    }

    public function index()
    {
        $settings = Setting::all();
        return response($settings);
    }
}
