<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'inventory_id',
        'quantity'
    ];

    public function getCartByUser($user_id){
        return $this->where('user_id', $user_id)->get();
    }

    public function fetchCartById($id) {
        return $this->where('id', $id)->first();
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
