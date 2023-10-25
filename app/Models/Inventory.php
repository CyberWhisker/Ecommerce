<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_name',
        'unit_id',
        'quantity',
        'price',
    ];
    public function getAllInventory(): Builder 
    {
        return static::query();
    }
    public function getInventory() {
        return $this->get();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    
    
}
