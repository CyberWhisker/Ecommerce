<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function authentication() {
        if (Auth::user()->role_as == '1') {
            return redirect('admin.dashboard')->with('status', 'Welcome to DashBoard');
        } else {
            return redirect('customer.dashboard')->with('status', 'Logged in');
        }
    }
}
