<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_of_visit',
        'patient_name',
        'ic_number',
        'phone_no',
        'gender',
        'age',
        'visit_setting',
        'referral_source',
        'triage_priority',
        'diabetes_type',
        'duration_years',
        'reason_for_referral',
        'weight_kg',
        'bmi',
        'bp',
        'hba1c',
        'egfr',
        'current_meds',
        'insulin_technique',
        'adherence_issue',
        'lipodystrophy',
        'dietary_pattern',
        'smoking_status',
        'hypoglycemia_history',
        'smbg_frequency',
        'topics_covered',
        'smart_goal',
        'next_follow_up',
        'educator_name',
    ];

    protected $casts = [
        'date_of_visit' => 'date',
        'next_follow_up' => 'date',
        'hba1c' => 'decimal:1',
        'bmi' => 'decimal:1',
        'weight_kg' => 'decimal:1',
    ];

    /**
     * Get HbA1c color class for display
     */
    public function getHbA1cColorAttribute(): string
    {
        $hba1c = (float) $this->hba1c;
        if ($hba1c < 6.5) return 'text-green-600';
        if ($hba1c < 8.0) return 'text-yellow-600';
        return 'text-red-600';
    }

    /**
     * Check if patient is high risk (HbA1c > 8%)
     */
    public function isHighRisk(): bool
    {
        return (float) $this->hba1c > 8.0;
    }

    /**
     * Generate HL7 ORU^R01 message
     */
    public function generateHL7Message(): string
    {
        $now = now()->format('YmdHis');
        $msgId = 'MSG' . mt_rand(10000, 99999);
        
        $msh = "MSH|^~\\&|DiabEduc|Klinik|HIS|Klinik|{$now}||ORU^R01|{$msgId}|P|2.5";
        
        $nameParts = explode(' ', $this->patient_name);
        $lastName = array_pop($nameParts);
        $firstName = implode('^', $nameParts);
        
        $dob = '';
        if ($this->ic_number && strlen($this->ic_number) >= 6) {
            $year = (int) substr($this->ic_number, 0, 2);
            $year += ($year > 30) ? 1900 : 2000;
            $dob = $year . substr($this->ic_number, 2, 4);
        }
        
        $gender = $this->gender === 'Male' ? 'M' : 'F';
        $pid = "PID|1||{$this->ic_number}||{$lastName}^{$firstName}||{$dob}|{$gender}";
        
        $visitDate = str_replace('-', '', $this->date_of_visit);
        $pv1 = "PV1|1|O|{$this->visit_setting}^{$this->referral_source}||||||||||||||||{$visitDate}";
        
        $obxSegments = [];
        $counter = 1;
        
        $obxSegments[] = "OBX|{$counter}|NM|4548-4^HbA1c||{$this->hba1c}|%||||F";
        $counter++;
        $obxSegments[] = "OBX|{$counter}|NM|39156-5^BMI||{$this->bmi}|kg/m2||||F";
        $counter++;
        $obxSegments[] = "OBX|{$counter}|NM|29463-7^Body Weight||{$this->weight_kg}|kg||||F";
        $counter++;
        $obxSegments[] = "OBX|{$counter}|NM|33914-3^eGFR||{$this->egfr}|mL/min||||F";
        
        return $msh . "\r" . $pid . "\r" . $pv1 . "\r" . implode("\r", $obxSegments);
    }
}
