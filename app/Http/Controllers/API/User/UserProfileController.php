<?php

namespace App\Http\Controllers\API\User;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function balance($id) {
        $account = Account::whereUserId($id)->first();
        return response($account);
    }
}
