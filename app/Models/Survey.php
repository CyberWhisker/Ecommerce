<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Survey extends Model
{
    protected $fillable = [
        'user_id',
        'product_name',
        'unit_id',
        'price',
        'survey_location',
    ];
    use HasFactory;
    
    public function getAllSurvey(): Builder 
    {
        return static::query();
    }

    public function getAllSurveyAverage(): Builder
    {
        return $this->select('unit_id', 'product_name', \DB::raw('AVG(price) as price'))
            ->groupBy('product_name', 'unit_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function searchSurvey($search_input) {
        return $this->where('product_name', 'like', '%' .$search_input. '%')
            ->get();
    }

    public function searchSurveyAvg($search_input) {
        return $this->select('unit', 'product_name', \DB::raw('AVG(price) as price'))
            ->leftJoin('units', 'surveys.unit_id', '=', 'units.id')
            ->where('product_name', 'like', '%' .$search_input. '%')
            ->groupBy('product_name', 'unit')
            ->first();
    }
}
