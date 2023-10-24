<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'unit'
    ];
    use HasFactory;

    public function getAllUnit(){
        return $this->get();
    }
}
