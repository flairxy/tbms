<?php

namespace App\Http\Controllers\API\Admin;

use App\Deposit;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDepositController extends Controller
{
    public function index(Request $request)
    {
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
        $deposit = Deposit::findOrFail($id);
        $deposit->delete();
        return response([
            'message' => 'Deposit deleted successfully',
            'status' => 'success'
        ]);
    }
}
