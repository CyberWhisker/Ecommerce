<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $inventory = new Inventory();
        $data_inventory =$inventory->getAllInventory()->paginate(10);
        return view('dashboard',[
            'data_inventory' => $data_inventory
        ]);
    }
}
