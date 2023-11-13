<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderStatus;
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

    public function indexDelivery(){

        $user_role = Auth::user()->role_as;
        $data_order_status = OrderStatus::all();
        return view('admin.delivery', [
            'user_role' => $user_role,
            'data_order_status' => $data_order_status
        ]);
    }

    public function updateOrderStatus(Request $request) {
        try {
            $request->validate([
                'order_id' => 'required'
            ]);
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
                    OrderStatus::updateOrCreate(
                        [
                            'order_id' => $request->order_id,
                        ],
                        [
                            'process_status' => 1,
                        ]
                    );
                }
            }
            if ($request->order_status == 'Cancelled') {
                $inventory = new Inventory();
                $inventory_quantity = $inventory->fetchInventoryById($request->inventory_id)->quantity;
                $new_inventory_quantity = $inventory_quantity + $request->quantity;
                Inventory::where('id', $request->inventory_id)->update([
                    'quantity' => $new_inventory_quantity
                ]);
                OrderStatus::where('order_id', $request->order_id)->update([
                    'process_status' => 0,
                    'delivery_status' => 0,
                    'recieve_status' => 0,
                ]);
            }
            Order::where('id', $request->order_id)->update([
                "order_status" => $request->order_status
            ]);
            
            return redirect()->back()->with('success', 'Order '. $request->order_status);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateOrderDelivery(Request $request) {
        try {
            $request->validate([
                'id' => ['required']
            ]);
            OrderStatus::where('id', $request->id)->update([
                'process_status' => 2,
                'delivery_status' => 1
            ]);
            return redirect()->back()->with('success', 'Status updated!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function udpateOrderRecieve(Request $request) {
        try {
            $request->validate([
                'id' => ['required']
            ]);
            OrderStatus::where('id', $request->id)->update([
                'delivery_status' => 2,
                'recieve_status' => 2
            ]);
            return redirect()->back()->with('success', 'Status updated!');
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

    public function searchDelivery(Request $request){
        $order_status = new OrderStatus();
        $user_role = Auth::user()->role_as;
        $data_order_status = $order_status->searchDelivery($request->searchInput);
        return view('admin.delivery', [
            'user_role' => $user_role,
            'data_order_status' => $data_order_status
        ]);
    }
}
