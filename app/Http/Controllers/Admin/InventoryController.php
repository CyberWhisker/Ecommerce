<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class InventoryController extends Controller
{
    public function index(){
        $inventory = new Inventory();
        $user_role = Auth::user()->role_as;
        $data_inventory = $inventory->getAllInventory()->paginate(15);
        return view('admin.inventory', [
            'data_inventory' => $data_inventory,
            'user_role' => $user_role,
        ]);
    }
}
