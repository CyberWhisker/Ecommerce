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
        $data_survey = $survey->getAllSurveyAverage()->paginate(5);
        $date_array = Session::get('date_array');
        $data_order = $order->getAllOrder();
        $date_condition = Session::get('date_condition');
        if ($date_condition === 'true') {
            $data_chart_inventory = $order->getOrderByArray($date_array);
            Session::put([
                "date_condition" => false
            ]);
        } elseif($date_condition === 'empty') {
            $data_chart_inventory = [];
            Session::put([
                "date_condition" => false
            ]);
        } else {
            $data_chart_inventory = $order->getOrderChart();
            Session::put([
                "date_condition" => false
            ]);
        }
        $chartDate = Session::get('chartDate');
        $chartType = Session::get('chartType');
        $array_horizontal = [];
        $array_horizontal2 = [];
        $array_vertical = [];
        $array_vertical2 = [];
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
        foreach($data_chart_inventory as $data) {
            $array_horizontal2 [] = $data->inventory->product_name;
        }
        foreach($data_chart_inventory as $data) {
            $array_vertical2 [] = $data->total_quantity;
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
            'array_horizontal2' => $array_horizontal2,
            'array_vertical2' => $array_vertical2,
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
        return redirect()->route('admin.dashboard');
    }

    public function exportPdf() {
        $user = new User();
        $order = new Order();
        $inventory = new Inventory();
        $user_count = $user->getUsers()->count();
        $data_order = $order->getAllOrder();
        $qauntity_inventory = $inventory->getAllInventory()->sum('quantity');
        $item_sold = number_format($order->where('order_status', 'Confirmed')->sum('quantity'), 0);
        $total_sale = '₱ '. number_format($order->where('order_status', 'Confirmed')->sum('price'), 2);
        $data_order = $order->getAllOrder();
        $user_data = Auth::user();
        $currentDate = Carbon::now();
        $daily_horizontal = [];
        $daily_vertical = [];
        $weekly_horizontal = [];
        $weekly_vertical = [];
        $monthly_horizontal = [];
        $monthly_vertical = [];
        //Daily Array
        $daily_chart_order = $order->getOrderChartByDay();
        foreach($daily_chart_order as $data) {
            $date = Carbon::parse($data->date)->format('M d');
            $daily_horizontal [] = $date;
        }
        foreach($daily_chart_order as $data) {
            $daily_vertical [] = $data->total_price;
        }
        //Weekly Array
        $weekly_chart_order = $order->getOrderChartByWeek();
        foreach($weekly_chart_order as $data) {
            $weekly_horizontal [] = $data->date;
        }
        foreach($weekly_chart_order as $data) {
            $weekly_vertical [] = $data->total_price;
        }
        //Monthly Array
        $monthly_chart_order = $order->getOrderChartByMonth();
        foreach($monthly_chart_order as $data) {
            $monthly_horizontal [] = $data->date;
        }
        foreach($monthly_chart_order as $data) {
            $monthly_vertical [] = $data->total_price;
        }
        
        return view('admin.export.exportPdf',[
            'user_count' => $user_count,
            'data_order' => $data_order,
            'daily_horizontal' => $daily_horizontal,
            'daily_vertical' => $daily_vertical,
            'monthly_horizontal' => $monthly_horizontal,
            'monthly_vertical' => $monthly_vertical,
            'weekly_horizontal' => $weekly_horizontal,
            'weekly_vertical' => $weekly_vertical,
            'qauntity_inventory' => $qauntity_inventory,
            'total_sale' => $total_sale,
            'item_sold' => $item_sold,
            'data_order' => $data_order,
            'user_data' => $user_data,
            'currentDate' => $currentDate
        ]);
    }

    public function inventoryDate(Request $request) {
        $date_array = [];
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $data_order = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        //Convert to array
        foreach ($data_order as $data) {
            $date_array [] = $data->id;
        }
        if (empty($date_array)) {
            Session::put([
                "date_condition" => 'empty',
            ]);
        } else {
            Session::put([
                "date_condition" => 'true',
                "date_array" => $date_array,
            ]);
        }
        return redirect()->route('admin.dashboard')->with([
            'startDate' => Carbon::parse($startDate)->format('Y-m-d'),
            'endDate' => Carbon::parse($endDate)->format('Y-m-d'),
        ]);
    }
}
