<?php

namespace App\Http\Controllers\API\Admin;

use App\Account;
use App\Deposit;
use App\Gateway;
use App\User;
use App\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDepositController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('isSAF');

        $filter = $request->filter;
        $filterSlug = $request->filterSlug;
        $number = $request->number;
        if ($filter) {
            $deposits = Deposit::where($filterSlug, $filter)->get();
            return response($deposits);
        }
        if ($number) {
            $deposits = Deposit::where($filterSlug, $filter)->paginate($number);
            return response($deposits);
        }
        $deposits = Deposit::paginate(25);
        return response($deposits);
    }

    public function delete($id)
    {
        $this->authorize('isSuperAdmin');
        $deposit = Deposit::findOrFail($id);
        $deposit->delete();
        return response([
            'message' => 'Deposit deleted successfully',
            'status' => 'success'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isSAF');

        $account = Account::whereUserId($request->user)->first();
        $gateway = Gateway::findOrFail($request->gateway);
        $deposit = Deposit::findOrFail($id);

        $deposit->status = $request->status;
        if ($request->status == '1') {
            $deposit->payment = 1;
            $deposit->save();

            if ($gateway->name === 'BITCOIN') {
                $account->btc += $deposit->net_amount;
                $account->save();

            } else {
                $account->eth += $deposit->net_amount;
                $account->save();
            }
        } else {
            $deposit->payment = 0;
            $deposit->save();

            if ($gateway->name === 'BITCOIN') {
                $account->btc -= $deposit->net_amount;
                $account->save();
            }else {
                $account->eth -= $deposit->net_amount;
                $account->save();
            }
        }
        return response($deposit);
    }

    public function total() {
        $sum = Deposit::whereStatus(1)->sum('net_amount');
        return response($sum);

    }

    public function totalWithdrawal() {
        $sum = Withdrawal::whereStatus(1)->sum('net_amount');
        return response($sum);

    }

    public function totalUsers() {
        $users = User::whereRole(0)->get();
        return response(count($users));
    }

    public function pendingWithdrawals() {
        $withdrawals = Withdrawal::whereStatus(0)->get();
        return response(count($withdrawals));
    }

    public function pendingDeposits() {
        $deposits = Deposit::whereStatus(0)->get();
        return response(count($deposits));
    }
}
