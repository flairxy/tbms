<?php

namespace App\Http\Controllers\API\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUsersController extends Controller
{
    public function index() {
        $users = User::all();
        return response($users);
    }
}
