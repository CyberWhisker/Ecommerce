<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'street',
        'barangay',
        'city',
        'province',
    ];
    public function fetchUserStore($user_id) {
        return $this->where('user_id', $user_id)->first();
    }
}
