<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $inventory = new Inventory();
        $user_data = Auth::user();
        $data_inventory =$inventory->getAllInventory()->paginate(10);
        return view('dashboard',[
            'data_inventory' => $data_inventory,
            'user_data' => $user_data
        ]);
    }
    public function searchProduct(Request $request) {
        $inventory = new Inventory();
        $user_data = Auth::user();
        $data_inventory =$inventory->searchInventory($request->searchInput);
        return view('dashboard',[
            'data_inventory' => $data_inventory,
            'user_data' => $user_data
        ]);
    }
}
