<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Curl;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function pay(Request $request) {
        $user = Auth::user();
        $inventory = new Inventory();
        $product = $inventory->fetchInventoryById($request->inventory_id);
        $product_price = number_format($product->price, 2);
        $product_price = $product_price * 100;
        $minimum_amount = 2000;
        if ($product_price * $request->quantity < $minimum_amount) {
            return redirect()->back()->with('error', "Amount should not be less than ₱" .$minimum_amount * .010);
        }
        $data = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'email' => $user->email,
                        'name' => $user->first_name.' '.$user->last_name,
                        'phone' => $user->phone_number,
                    ],
                    'line_items' => [
                        [
                            'currency'      => 'PHP',
                            'amount'        => $product_price,
                            'description'   => 'Sample Product',
                            'name'          => $product->product_name,
                            'quantity'      => intval($request->quantity),
                        ]
                    ],
                    'payment_method_types' => [
                        'card',
                    ],
                    'success_url' => 'http://localhost:8000/success',
                    'cancel_url' => 'http://localhost:8000',
                    'description' => 'Ordered Product'
                ],
            ]
       ];
       $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
            ->withHeader('Content-Type: application/json')
            ->withHeader('accept: application/json')
            ->withHeader('Authorization: Basic '.base64_encode('sk_test_qqozF1K94HBX1ErwuBnJ6myL'))
            ->withData($data)
            ->asJson()
            ->post();
        \Session::put([
            'session_id' => $response->data->id,
            'inventory_id' => $request->inventory_id,
            'user_id' => $user->id,
        ]);
        return redirect()->to($response->data->attributes->checkout_url);
    }

    public function success() {
        $session_id = \Session::get('session_id'); // Make sure to use the correct session variable name
        $inventory_id = \Session::get('inventory_id');
        $user_id = \Session::get('user_id');
        $response = Curl::to("https://api.paymongo.com/v1/checkout_sessions/{$session_id}")
            ->withHeader('accept: application/json')
            ->withHeader('Authorization: Basic ' . base64_encode('sk_test_qqozF1K94HBX1ErwuBnJ6myL'))
            ->asJson()
            ->get(); // Use GET instead of POST for retrieving information
        $data_line_items = $response->data->attributes->line_items;
        try {
            DB::beginTransaction();
            $order = new Order();
            $inventory = new Inventory();
            foreach ($data_line_items as $data) {
                $price = $data->quantity * $data->amount;
                $price = $price * .01;
                Order::create([
                    'user_id' => $user_id,
                    'inventory_id' => $inventory_id,
                    'quantity' => $data->quantity,
                    'price' => $price,
                    'order_status' => 'Confirmed',
                ]);
                $order_id = $order->fetchLatestOrderByUserId($user_id)->id;
                OrderStatus::create([
                    'order_id' => $order_id,
                    'process_status' => 1
                ]);
                $new_inv_quantity = $inventory->fetchInventoryById($inventory_id)->quantity - $data->quantity;
                Inventory::where('id', $inventory_id)->update([
                    'quantity' => $new_inv_quantity
                ]);
            }
            $data_order = $order->getOrderByUserId($user_id);
            DB::commit();
            return view('customer.order', [
                'data_order' => $data_order
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }
    public function cancel() {
        return redirect()->back();
    }
}
