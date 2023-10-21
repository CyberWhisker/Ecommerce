<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index() {
        $user_role = Auth::user()->role_as;
        return view('admin.dashboard',[
            'user_role' => $user_role,
        ]);
    }
}
