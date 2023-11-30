<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function dashboardAlert() {
        return redirect()->back()->with(['error' => 'You are not login. Please login or create an account.']);
    }
}
