<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index() {
        $user = new User();
        $inventory = new Inventory();
        $survey = new Survey();
        $user_count = $user->getUsers()->count();
        $user_role = Auth::user()->role_as;
        $data_survey = $survey->getAllSurvey()->paginate(5);
        //Convert into array
        $array_horizontal = [];
        $array_vertical = [];
        $getInventory = $inventory->getInventory();
        foreach($getInventory as $data) {
            $array_horizontal [] = $data['product_name'];
        }
        foreach($getInventory as $data) {
            $array_vertical [] = $data['quantity'];
        }
        return view('admin.dashboard',[
            'user_role' => $user_role,
            'user_count' => $user_count,
            'array_horizontal' => $array_horizontal,
            'array_vertical' => $array_vertical,
            'data_survey' => $data_survey
        ]);
    }
}
