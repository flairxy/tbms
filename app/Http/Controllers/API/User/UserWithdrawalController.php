<?php

namespace App\Http\Controllers\API\User;

use App\Account;
use App\Gateway;
use App\Setting;
use App\Withdrawal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class UserWithdrawalController extends Controller
{

    public function create(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'gateway' => 'required',
            'address' => 'required',
        ]);

        $rate = Setting::whereName('BKY_EXCHANGE_RATE')->first();
        $gateway = Gateway::findOrFail($request->gateway);
        $account = Account::whereUserId($request->user)->first();
        $charge = (($gateway->charge / 100) * $request->amount);
        if ($account->bky >= $request->amount) {
            Withdrawal::create([
                'transaction_id' => Str::random(10),
                'user_id' => $request->user,
                'charge' => $charge,
                'address' => $request->address,
                'gateway' => $gateway->name,
                'status' => 0,
                'net_amount' => $request->amount - $charge,
            ]);

            $account->bky -= $request->amount;
            $account->bky2 -= $request->amount / $rate->value;
            $account->save();

            return response([
                'message' => 'Withdrawal request successful',
                'status' => 'success',
            ]);
        }
        return response([
            'message' => 'Insufficient funds',
            'status' => 'error',
        ]);
    }

    public function index($id) {
        $withdrawals = Withdrawal::whereUserId($id)->orderBy('id', 'desc')->get();
        return response($withdrawals);
    }
}
