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
     * Based on IWGDF/CPG Guidelines
     */
    public static function determineRisk($data, $patient = null)
    {
        $r_lops = !($data['r_sensation'] ?? true);
        $l_lops = !($data['l_sensation'] ?? true);
        $lops = $r_lops || $l_lops;

        $r_pad = (($data['r_pulse_dp'] ?? 'Present') !== 'Present' || ($data['r_pulse_pt'] ?? 'Present') !== 'Present');
        $l_pad = (($data['l_pulse_dp'] ?? 'Present') !== 'Present' || ($data['l_pulse_pt'] ?? 'Present') !== 'Present');
        $pad = $r_pad || $l_pad;

        $r_deformity = (bool) ($data['r_deformity'] ?? false);
        $l_deformity = (bool) ($data['l_deformity'] ?? false);
        $deformity = $r_deformity || $l_deformity;

        $r_history = ($data['r_ulcer'] ?? false) || ($data['r_amputation'] ?? false);
        $l_history = ($data['l_ulcer'] ?? false) || ($data['l_amputation'] ?? false);
        $history = $r_history || $l_history;

        // Check for ESRD (eGFR < 15)
        $esrd = false;
        if ($patient && isset($patient->egfr)) {
            $esrd = $patient->egfr < 15;
        }

        // Category 3: (LOPS or PAD) AND (History of ulcer/amputation OR ESRD)
        if (($lops || $pad) && ($history || $esrd)) {
            return ['3', 'Very High Risk'];
        }

        // Category 2: LOPS + PAD, or LOPS + Deformity, or PAD + Deformity
        if (($lops && $pad) || ($lops && $deformity) || ($pad && $deformity)) {
            return ['2', 'High Risk'];
        }

        // Category 1: LOPS or PAD only
        if ($lops || $pad) {
            return ['1', 'Moderate Risk'];
        }

        // Category 0: No LOPS and No PAD
        return ['0', 'Low Risk'];
    }
}
