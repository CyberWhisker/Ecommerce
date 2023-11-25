<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $chartDate = Session::get('chartDate');
        $chartType = Session::get('chartType');
        $array_horizontal = [];
        $array_vertical = [];
        if ($chartDate == 2) {
            $data_chart_order = $order->getOrderChartByWeek();
            foreach($data_chart_order as $data) {
                $array_horizontal [] = $data->date;
            }
        } elseif($chartDate == 3) {
            $data_chart_order = $order->getOrderChartByMonth();
            foreach($data_chart_order as $data) {
                $array_horizontal [] = $data->date;
            }
        } else {
            $data_chart_order = $order->getOrderChartByDay();
            foreach($data_chart_order as $data) {
                $date = Carbon::parse($data->date)->format('M d');
                $array_horizontal [] = $date;
            }
        }
        //Convert into array
        foreach($data_chart_order as $data) {
            $array_vertical [] = $data->total_price;
        }
        //Default Value
        if (!$chartDate) {
            $chartDate = 1;
        }
        if (!$chartType) {
            $chartType = 1;
        }
        return view('admin.dashboard',[
            'user_role' => $user_role,
            'user_count' => $user_count,
            'data_survey' => $data_survey,
            'data_order' => $data_order,
            'array_horizontal' => $array_horizontal,
            'array_vertical' => $array_vertical,
            'chartDate' => $chartDate,
            'chartType' => $chartType,
        ]);
    }

    public function chartDate(Request $request) {
        Session::put([
            'chartDate' => $request->chartDate
        ]);
        return redirect()->route('dashboard');
    }
    public function chartType(Request $request) {
        Session::put([
            'chartType' => $request->chartType
        ]);
        return redirect()->route('dashboard');
    }
}
