<?php

namespace Tests\Feature;

use App\Models\FootAssessment;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FootAssessmentRiskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_correctly_identifies_low_risk_category_0()
    {
        $data = [
            'r_pulse_dp' => 'Present',
            'r_pulse_pt' => 'Present',
            'l_pulse_dp' => 'Present',
            'l_pulse_pt' => 'Present',
            'r_sensation' => true,
            'l_sensation' => true,
            'r_deformity' => false,
            'l_deformity' => false,
            'r_ulcer' => false,
            'l_ulcer' => false,
            'r_amputation' => false,
            'l_amputation' => false,
        ];

        [$category, $level] = FootAssessment::determineRisk($data);
        $this->assertEquals('0', $category);
        $this->assertEquals('Low Risk', $level);
    }

    /** @test */
    public function it_identifies_moderate_risk_category_1_with_lops()
    {
        $data = [
            'r_sensation' => false, // LOPS
            'l_sensation' => true,
        ];

        [$category, $level] = FootAssessment::determineRisk($data);
        $this->assertEquals('1', $category);
        $this->assertEquals('Moderate Risk', $level);
    }

    /** @test */
    public function it_identifies_moderate_risk_category_1_with_pad()
    {
        $data = [
            'r_pulse_dp' => 'Reduced', // PAD
            'r_pulse_pt' => 'Present',
            'r_sensation' => true,
            'l_sensation' => true,
        ];

        [$category, $level] = FootAssessment::determineRisk($data);
        $this->assertEquals('1', $category);
    }

    /** @test */
    public function it_identifies_high_risk_category_2_with_lops_and_pad()
    {
        $data = [
            'r_sensation' => false, // LOPS
            'l_pulse_dp' => 'Absent', // PAD
        ];

        [$category, $level] = FootAssessment::determineRisk($data);
        $this->assertEquals('2', $category);
        $this->assertEquals('High Risk', $level);
    }

    /** @test */
    public function it_identifies_very_high_risk_category_3_with_history_of_ulcer()
    {
        $data = [
            'r_sensation' => false, // LOPS
            'r_ulcer' => true, // History
        ];

        [$category, $level] = FootAssessment::determineRisk($data);
        $this->assertEquals('3', $category);
        $this->assertEquals('Very High Risk', $level);
    }

    /** @test */
    public function it_identifies_very_high_risk_category_3_with_esrd()
    {
        $patient = new Patient(['egfr' => 12]);
        $data = [
            'r_sensation' => false, // LOPS
        ];

        [$category, $level] = FootAssessment::determineRisk($data, $patient);
        $this->assertEquals('3', $category);
    }
}
