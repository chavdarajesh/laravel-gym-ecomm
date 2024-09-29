<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
    }
    public function dashboard()
    {
        return view('user.dashboard');
    }
}
