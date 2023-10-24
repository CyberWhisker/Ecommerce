<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'user_id',
        'product_name',
        'unit',
        'price',
        'survey_location',
    ];
    use HasFactory;
    
    public function getAllSurvey(): Builder 
    {
        return static::query();
    }
}
