<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
        try {
            $request->validate([
                'id' => 'required',
            ]);
            Cart::where('id', $request->id)->delete();
            return redirect()->back()->with('error', 'Successfully deleted from Survey');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
