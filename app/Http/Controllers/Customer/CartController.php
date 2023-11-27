<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Inventory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $id = Auth::user()->id;
        $cart = new Cart();
        $data_cart = $cart->getCartByUser($id);
        return view('customer.cart',[
            'data_cart' => $data_cart
         ]);
    }
    public function storeCart(Request $request) {
        $user_id = Auth::user()->id;
        try {
            $request->validate([
                'inventory_id' => ['required'],
                'quantity' => ['required'],
            ]);
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
            Cart::create([
                'user_id' => $user_id,
                'inventory_id' => $request->inventory_id,
                'quantity' => $request->quantity,
            ]);
            return redirect()->back()->with('success', 'Successfully inserted to Cart');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteCart(Request $request) {
        $cart = new Cart();
        $cart_quantity = $cart->fetchCartById($request->id)->quantity;
        $inventory_id = $cart->fetchCartById($request->id)->inventory->id;
        $inventory_quantity = $cart->fetchCartById($request->id)->inventory->quantity;
        $new_quantity = $cart_quantity + $inventory_quantity;
        try {
            $request->validate([
                'id' => 'required',
            ]);
            Inventory::where('id', $inventory_id)
                ->update([
                'quantity' => $new_quantity
            ]);
            Cart::where('id', $request->id)->delete();
            return redirect()->back()->with('error', 'Successfully deleted from Survey');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
