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
    public function updateSurvey(Request $request) {
        $user_id = Auth::user()->id;
        $price = $request->price;
        try {
            $request->validate([
                'product_name' => ['required'],
                'price' => ['required', 'numeric'],
                'unit_id' => ['required'],
                'survey_location' => ['required']
            ]);
            $price = number_format($price,2);
            Survey::where('id', $request->id)->update([
                'user_id' => $user_id,
                'product_name' => $request->product_name,
                'survey_location' => $request->survey_location,
                'unit_id' => $request->unit_id,
                'price' => $price,

            ]);
            return redirect()->back()->with('success', 'Successfully updated to Survey');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteSurvey(Request $request) {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            Survey::where('id', $request->id)->delete();
            return redirect()->back()->with('success', 'Successfully deleted from Survey');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
