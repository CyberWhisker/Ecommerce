<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $user_id = Auth::user()->id;
        $order = new Order();
        $data_order = $order->getOrderByUserId($user_id);
        return view('customer.order',[
            'data_order' => $data_order
         ]);
    }

    public function storeOrder(Request $request){
        $user_id = Auth::user()->id;
        $inventory = new Inventory();
        $inventory_price = $inventory->fetchInventoryById($request->inventory_id)->price;
        $price = $request->quantity * $inventory_price;
        try {
            $request->validate([
                'inventory_id' => 'required',
                'quantity' => 'required',
            ]);
            Order::create([
                'user_id' => $user_id,
                'inventory_id' => $request->inventory_id,
                'quantity' => $request->quantity,
                'price' => $price,
            ]);
            if ($request->cart_id != null) {
                Cart::where('id', $request->cart_id)->delete();
            }
            return redirect()->back()->with('success', 'Order is now Pending');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteOrder(Request $request) {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            Order::where('id', $request->id)->delete();
            return redirect()->back()->with('success', 'Order Has been Cancelled');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reviewOrder(Request $request) {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            Order::where('id',$request->id)
                ->update([
                    'review' => $request->review,
                    'rating' => $request->rating,
                ]);
            return redirect()->back()->with('success', 'Order has been Reviewed');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
