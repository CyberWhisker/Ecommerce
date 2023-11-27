<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'inventory_id',
        'quantity',
        'order_status',
        'price',
        'review',
    ];

    public function getOrderByUserId($user_id) {
        return $this->where('user_id', $user_id)->get();
    } 

    public function fetchLatestOrderByUserId($user_id) {
        return $this->where('user_id', $user_id)->latest()->first();
    }

    public function getOrderChart() {
        return $this->select('inventory_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('inventory_id')
            ->get();
    }

    public function getOrderChartByDay() {
        return $this->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), 
                DB::raw('SUM(price) as total_price')
            )
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))
            ->get();
    }

    public function getOrderChartByWeek() {
        return $this->select(
                DB::raw('DATE_FORMAT(created_at, "Week %u") as date'),
                DB::raw('SUM(price) as total_price')
            )
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "Week %u")'))
            ->get();
    }
    
    public function getOrderChartByMonth() {
        return $this->select(
                DB::raw('DATE_FORMAT(created_at, "%b") as date'),
                DB::raw('SUM(price) as total_price')
            )
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b")'))
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

    public function getOrderByArray($array) {
        return $this->select('inventory_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereIn('id', $array)
            ->groupBy('inventory_id')
            ->get();
    }
}
