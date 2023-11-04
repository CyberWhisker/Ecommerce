<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $order = new Order();

        $user_role = Auth::user()->role_as;
        $data_order = $order->getAllOrder();
        return view('admin.order', [
            'user_role' => $user_role,
            'data_order' => $data_order
        ]);
    }

    public function updateOrderStatus(Request $request) {
        if ($request->order_status == 'Confirmed') {
            $inventory = new Inventory();
            $inventory_quantity = $inventory->fetchInventoryById($request->inventory_id)->quantity;
            $new_inventory_quantity = $inventory_quantity - $request->quantity;
            if ($new_inventory_quantity < 0) {
                return redirect()->back()->with('error', 'Out of Stock');
            } else {
                Inventory::where('id', $request->inventory_id)->update([
                    'quantity' => $new_inventory_quantity
                ]);
            }
        }
        try {
            $request->validate([
                'order_id' => 'required'
            ]);
            Order::where('id', $request->order_id)->update([
                "order_status" => $request->order_status
            ]);
            return redirect()->back()->with('success', 'Order '. $request->order_status);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    
    public function searchOrder(Request $request) {
        $order = new Order();
        $user_role = Auth::user()->role_as;
        $search_input = $request->searchInput;
        $data_order = $order->searchOrder($search_input);
        return view('admin.order',[
            'data_order' => $data_order, 
            'user_role' => $user_role,
        ]);
    }
}
