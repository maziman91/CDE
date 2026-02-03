<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootAssessment extends Model
{
    protected $fillable = [
        'patient_id',
        'assessment_date',
        'r_pulse_dp',
        'r_pulse_pt',
        'r_sensation',
        'r_deformity',
        'r_callus',
        'r_ulcer',
        'r_amputation',
        'l_pulse_dp',
        'l_pulse_pt',
        'l_sensation',
        'l_deformity',
        'l_callus',
        'l_ulcer',
        'l_amputation',
        'remarks',
        'risk_category',
        'risk_level'
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'r_sensation' => 'boolean',
        'r_deformity' => 'boolean',
        'r_callus' => 'boolean',
        'r_ulcer' => 'boolean',
        'r_amputation' => 'boolean',
        'l_sensation' => 'boolean',
        'l_deformity' => 'boolean',
        'l_callus' => 'boolean',
        'l_ulcer' => 'boolean',
        'l_amputation' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Map category to human readable level and color
     */
    public function getRiskBadgeAttribute()
    {
        return [
            '0' => ['label' => 'Low Risk', 'color' => 'bg-green-100 text-green-800'],
            '1' => ['label' => 'Moderate Risk', 'color' => 'bg-blue-100 text-blue-800'],
            '2' => ['label' => 'High Risk', 'color' => 'bg-orange-100 text-orange-800'],
            '3' => ['label' => 'Very High Risk', 'color' => 'bg-red-100 text-red-800'],
        ][$this->risk_category] ?? ['label' => 'Unknown', 'color' => 'bg-gray-100 text-gray-800'];
    }

    /**
     * Logic to determine risk category based on parameters
     */
    public static function determineRisk($data)
    {
        // Category 3: History of ulcer or amputation (either foot)
        if ($data['r_ulcer'] || $data['r_amputation'] || $data['l_ulcer'] || $data['l_amputation']) {
            return ['3', 'Very High Risk'];
        }

        $r_lops = !$data['r_sensation'];
        $l_lops = !$data['l_sensation'];
        $r_pad = ($data['r_pulse_dp'] !== 'Present' || $data['r_pulse_pt'] !== 'Present');
        $l_pad = ($data['l_pulse_dp'] !== 'Present' || $data['l_pulse_pt'] !== 'Present');

        // Category 2: LOPS + Deformity or PAD
        if (($r_lops && ($data['r_deformity'] || $r_pad)) || ($l_lops && ($data['l_deformity'] || $l_pad))) {
            return ['2', 'High Risk'];
        }

        // Category 1: LOPS only
        if ($r_lops || $l_lops) {
            return ['1', 'Moderate Risk'];
        }

        // Category 0: No LOPS
        return ['0', 'Low Risk'];
    }
}
