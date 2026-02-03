<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    protected $fillable = [
        'name',
        'ic_number',
        'age',
        'gender',
        'bmi',
        'physical_activity',
        'family_history',
        'history_high_bp',
        'history_high_glucose',
        'total_score',
        'risk_level',
    ];

    /**
     * Get CSS class for risk level
     */
    public function getRiskColorAttribute()
    {
        return [
            'Low' => 'text-green-600 bg-green-50',
            'Moderate' => 'text-yellow-600 bg-yellow-50',
            'High' => 'text-red-600 bg-red-50',
        ][$this->risk_level] ?? 'text-gray-600 bg-gray-50';
    }
}
