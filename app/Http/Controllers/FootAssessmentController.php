<?php

namespace App\Http\Controllers;

use App\Models\FootAssessment;
use App\Models\Patient;
use Illuminate\Http\Request;

class FootAssessmentController extends Controller
{
    /**
     * Display a listing of assessments for a patient.
     */
    public function index(Request $request)
    {
        $patient = Patient::findOrFail($request->patient_id);
        $assessments = $patient->footAssessments()->latest()->paginate(10);

        return view('foot_assessments.index', compact('patient', 'assessments'));
    }

    /**
     * Show the form for creating a new assessment.
     */
    public function create(Request $request)
    {
        $patient = Patient::findOrFail($request->patient_id);
        return view('foot_assessments.create', compact('patient'));
    }

    /**
     * Store a newly created assessment.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'assessment_date' => 'required|date',
            'r_pulse_dp' => 'required|string',
            'r_pulse_pt' => 'required|string',
            'r_sensation' => 'required|boolean',
            'r_deformity' => 'required|boolean',
            'r_callus' => 'required|boolean',
            'r_ulcer' => 'required|boolean',
            'r_amputation' => 'required|boolean',
            'l_pulse_dp' => 'required|string',
            'l_pulse_pt' => 'required|string',
            'l_sensation' => 'required|boolean',
            'l_deformity' => 'required|boolean',
            'l_callus' => 'required|boolean',
            'l_ulcer' => 'required|boolean',
            'l_amputation' => 'required|boolean',
            'remarks' => 'nullable|string',
        ]);

        $patient = Patient::findOrFail($data['patient_id']);
        [$category, $level] = FootAssessment::determineRisk($data, $patient);
        $data['risk_category'] = $category;
        $data['risk_level'] = $level;

        FootAssessment::create($data);

        return redirect()->route('foot_assessments.index', ['patient_id' => $data['patient_id']])
            ->with('success', 'Foot assessment recorded successfully. Risk Level: ' . $level);
    }

    /**
     * Display the specified assessment.
     */
    public function show(FootAssessment $footAssessment)
    {
        return view('foot_assessments.show', compact('footAssessment'));
    }

    /**
     * Remove the specified assessment.
     */
    public function destroy(FootAssessment $footAssessment)
    {
        $patientId = $footAssessment->patient_id;
        $footAssessment->delete();

        return redirect()->route('foot_assessments.index', ['patient_id' => $patientId])
            ->with('success', 'Assessment deleted.');
    }
}
