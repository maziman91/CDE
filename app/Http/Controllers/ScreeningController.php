<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Patient;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    public function index()
    {
        $screenings = Screening::latest()->paginate(10);
        return view('screenings.index', compact('screenings'));
    }

    public function create()
    {
        return view('screenings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_number' => 'nullable|string|max:20',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female',
            'bmi' => 'required|numeric|min:0',
            'physical_activity' => 'required|boolean',
            'family_history' => 'required|in:none,distant,immediate',
            'history_high_bp' => 'required|boolean',
            'history_high_glucose' => 'required|boolean',
        ]);

        $score = $this->calculateRiskScore($validated);
        $riskLevel = $this->determineRiskLevel($score);

        $screening = Screening::create(array_merge($validated, [
            'total_score' => $score,
            'risk_level' => $riskLevel
        ]));

        return redirect()->route('screenings.show', $screening)
            ->with('success', 'Screening completed successfully!');
    }

    public function show(Screening $screening)
    {
        return view('screenings.show', compact('screening'));
    }

    public function convertToPatient(Screening $screening)
    {
        // Pre-fill patient creation form with screening data
        session()->flash('screening_data', $screening->only([
            'name',
            'ic_number',
            'age',
            'gender',
            'bmi'
        ]));

        return redirect()->route('patients.create');
    }

    private function calculateRiskScore($data)
    {
        $score = 0;

        // Age
        if ($data['age'] >= 65)
            $score += 4;
        elseif ($data['age'] >= 55)
            $score += 3;
        elseif ($data['age'] >= 45)
            $score += 2;

        // BMI
        if ($data['bmi'] > 30)
            $score += 3;
        elseif ($data['bmi'] >= 25)
            $score += 1;

        // Activity
        if (!$data['physical_activity'])
            $score += 2;

        // Family History
        if ($data['family_history'] === 'immediate')
            $score += 5;
        elseif ($data['family_history'] === 'distant')
            $score += 3;

        // History
        if ($data['history_high_bp'])
            $score += 2;
        if ($data['history_high_glucose'])
            $score += 5;

        return $score;
    }

    private function determineRiskLevel($score)
    {
        if ($score > 14)
            return 'High';
        if ($score >= 7)
            return 'Moderate';
        return 'Low';
    }

    public function destroy(Screening $screening)
    {
        $screening->delete();
        return redirect()->route('screenings.index')->with('success', 'Screening deleted.');
    }
}
