<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Survey;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index(Request $request) {
        $user = new User();
        $inventory = new Inventory();
        $survey = new Survey();
        $order = new Order();
        $user_count = $user->getUsers()->count();
        $user_role = Auth::user()->role_as;
        $data_survey = $survey->getAllSurvey()->paginate(5);
        $data_order = $order->getAllOrder();
        $data_chart_order = $order->getOrderChart();
        //Convert into array
        $array_horizontal = [];
        $array_vertical = [];
        foreach($data_chart_order as $data) {
            $array_horizontal [] = $data->inventory->product_name;
        }
        foreach($data_chart_order as $data) {
            $array_vertical [] = $data->total_price;
        }
        return view('admin.dashboard',[
            'user_role' => $user_role,
            'user_count' => $user_count,
            'data_survey' => $data_survey,
            'data_order' => $data_order,
            'array_horizontal' => $array_horizontal,
            'array_vertical' => $array_vertical,
        ]);
    }
}
