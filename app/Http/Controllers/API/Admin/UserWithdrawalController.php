<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdrawal;

class UserWithdrawalController extends Controller
{
    public function index(Request $request) {
        $filter = $request->filter;
        $filterSlug = $request->filterSlug;
        $number = $request->number;
        if ($filter) {
            $deposits = Withdrawal::where($filterSlug, $filter)->get();
            return response($deposits);
        }
        if ($number) {
            $deposits = Withdrawal::where($filterSlug, $filter)->paginate($number);
            return response($deposits);
        }
        $deposits = Withdrawal::paginate(25);
        return response($deposits);
    }

    public function reject($id) {
        Withdrawal::whereId($id)->update([
            'status' => 2
        ]);
        return response('Withdrawal request rejected');
    }

    public function approve($id) {
        Withdrawal::whereId($id)->update([
            'status' => 1
        ]);
        return response('Withdrawal request approved');
    }

    public function delete($id) {
        $deposit = Withdrawal::findOrFail($id);
        $deposit->delete();
        return response('Withdrawal request deleted successfully');

    }
}
