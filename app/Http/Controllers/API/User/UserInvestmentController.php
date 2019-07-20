<?php

namespace App\Http\Controllers\API\User;

use App\Account;
use App\Gateway;
use App\Investment;
use App\Plan;
use App\Setting;
use App\Style;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class UserInvestmentController extends Controller
{
    public function create(Request $request) {

        $this->validate($request, [
            'amount' => 'required',
            'gateway' => 'required',
            'plan' => 'required',
        ]);

        $plan = Plan::findOrFail($request->plan);
        $start = Carbon::now();
        $end = Carbon::now()->addWeeks($plan->duration);
        $rate = Setting::whereName('BKY_EXCHANGE_RATE')->first();

        $account = Account::whereUserId($request->user)->first();

        if($account->bky >= $request->amount) {
            Investment::create([
                'end' => $end,
                'start' => $start,
                'amount' => $request->amount,
                'user_id' => $request->user,
                'plan' => $plan->name,
                'gateway' => $request->gateway,
                'charge' => $request->charge ?? 0,
                'reference_id' => Str::random(10),
            ]);
            $account->bky -= $request->amount;
            $account->bky2 -= $request->amount / $rate->value;
            $account->save();

            return response([
                'message' => 'Investment Successful',
                'status' => 'success'
            ]);
        }
        return response([
            'message' => 'Insufficient Fund',
            'status' => 'error'
        ]);
    }

    public function index($id) {
        $investments = Investment::whereUserId($id)->get();
        return response($investments);
    }
}
