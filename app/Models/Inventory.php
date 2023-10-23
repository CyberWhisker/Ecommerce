<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_name',
        'unit',
        'survey_location',
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
}
