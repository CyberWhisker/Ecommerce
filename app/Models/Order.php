<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'inventory_id',
        'quantity',
        'order_status',
        'price',
    ];

    public function getOrderByUserId($user_id) {
        return $this->where('user_id', $user_id)->get();
    } 

    public function fetchLatestOrderByUserId($user_id) {
        return $this->where('user_id', $user_id)->latest()->first();
    }

    public function getOrderChart() {
        return $this->select('inventory_id', \DB::raw('SUM(price) as total_price'))
            ->groupBy('inventory_id')
            ->get();
    }
    

    public function getAllOrder() {
        return $this->get();
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function orderStatus(){
        return $this->belongsTo(OrderStatus::class, 'id', 'order_id');
    }

    public function searchOrder($search_input) {
        return $this->whereHas('user', function($query) use ($search_input) {
                $query->where('last_name', 'like', '%' .$search_input. '%')
                    ->orWhere('first_name', 'like', '%'. $search_input. '%');
            })
            ->orWhereHas('inventory', function($query) use ($search_input) {
                $query->where('product_name', 'like', '%' .$search_input. '%');
            })
            ->get();
    }
}
