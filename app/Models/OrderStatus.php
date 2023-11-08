<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'process_status',
        'delivery_status',
        'recieved_status',
    ];
    public $timestamps = false;
    public function fetchOrderById($order_id) {
        return $this->where('id', $order_id)->first();
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function searchDelivery($search_input) {
        return $this->whereHas('order', function($order) use ($search_input) {
                $order->whereHas('user', function($query) use ($search_input) {
                    $query->where('last_name', 'like', '%' .$search_input. '%')
                    ->orWhere('first_name', 'like', '%'. $search_input. '%')
                    ->orWhere('address', 'like', '%'. $search_input. '%');
                });
                $order->orWhereHas('inventory', function($query) use ($search_input) {
                    $query->where('product_name', 'like', '%' .$search_input. '%');
                });
            })
            ->get();
    }
}
