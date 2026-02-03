<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * Display the main dashboard
     */
    /**
     * Display the stats dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total' => Patient::count(),
            'avg_hba1c' => Patient::avg('hba1c'),
            'high_risk' => Patient::where('hba1c', '>', 8.0)->count(),
            'avg_bmi' => Patient::avg('bmi'),
        ];

        return view('dashboard', compact('stats'));
    }

    /**
     * Display the patient registry
     */
    public function index(Request $request)
    {
        $query = Patient::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('ic_number', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(10)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Show the form for editing the specified patient
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Store a new patient
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_of_visit' => 'required|date',
            'patient_name' => 'required|string|max:255',
            'ic_number' => 'required|string|max:20|unique:patients',
            'phone_no' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female',
            'age' => 'nullable|integer',
            'visit_setting' => 'required|in:Outpatient,Inpatient',
            'referral_source' => 'nullable|string|max:255',
            'triage_priority' => 'required|string',
            'diabetes_type' => 'required|in:T2DM,T1DM,GDM',
            'duration_years' => 'nullable|integer',
            'reason_for_referral' => 'nullable|string',
            'weight_kg' => 'nullable|numeric',
            'bmi' => 'nullable|numeric',
            'bp' => 'nullable|string|max:20',
            'hba1c' => 'nullable|numeric',
            'egfr' => 'nullable|integer',
            'current_meds' => 'nullable|string',
            'insulin_technique' => 'nullable|string',
            'adherence_issue' => 'nullable|string',
            'lipodystrophy' => 'nullable|string',
            'dietary_pattern' => 'nullable|string',
            'smoking_status' => 'nullable|in:Non-Smoker,Smoker,Ex-Smoker',
            'hypoglycemia_history' => 'nullable|string',
            'smbg_frequency' => 'nullable|string',
            'topics_covered' => 'nullable|string',
            'smart_goal' => 'nullable|string',
            'next_follow_up' => 'nullable|date',
            'educator_name' => 'required|string|max:255',
        ]);

        try {
            Patient::create($validated);
            return redirect()->route('patients.index')
                ->with('success', 'Patient record created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating patient: ' . $e->getMessage());
            return back()->with('error', 'Failed to create patient record.');
        }
    }

    /**
     * Update a patient
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date_of_visit' => 'required|date',
            'patient_name' => 'required|string|max:255',
            'ic_number' => 'required|string|max:20|unique:patients,ic_number,' . $patient->id,
            'phone_no' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female',
            'age' => 'nullable|integer',
            'visit_setting' => 'required|in:Outpatient,Inpatient',
            'referral_source' => 'nullable|string|max:255',
            'triage_priority' => 'required|string',
            'diabetes_type' => 'required|in:T2DM,T1DM,GDM',
            'duration_years' => 'nullable|integer',
            'reason_for_referral' => 'nullable|string',
            'weight_kg' => 'nullable|numeric',
            'bmi' => 'nullable|numeric',
            'bp' => 'nullable|string|max:20',
            'hba1c' => 'nullable|numeric',
            'egfr' => 'nullable|integer',
            'current_meds' => 'nullable|string',
            'insulin_technique' => 'nullable|string',
            'adherence_issue' => 'nullable|string',
            'lipodystrophy' => 'nullable|string',
            'dietary_pattern' => 'nullable|string',
            'smoking_status' => 'nullable|in:Non-Smoker,Smoker,Ex-Smoker',
            'hypoglycemia_history' => 'nullable|string',
            'smbg_frequency' => 'nullable|string',
            'topics_covered' => 'nullable|string',
            'smart_goal' => 'nullable|string',
            'next_follow_up' => 'nullable|date',
            'educator_name' => 'required|string|max:255',
        ]);

        try {
            $patient->update($validated);
            return redirect()->route('patients.index')
                ->with('success', 'Patient record updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating patient: ' . $e->getMessage());
            return back()->with('error', 'Failed to update patient record.');
        }
    }

    /**
     * Delete a patient
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return redirect()->route('patients.index')
                ->with('success', 'Patient record deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting patient: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete patient record.');
        }
    }

    /**
     * Generate HL7 message for a patient
     */
    public function hl7(Patient $patient)
    {
        return response($patient->generateHL7Message())
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . str_replace(' ', '_', $patient->patient_name) . '.hl7"');
    }

    /**
     * Export all patients as CSV
     */
    public function exportCsv()
    {
        $patients = Patient::all();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="diabetes_registry.csv"',
        ];

        $columns = [
            'Date of Visit',
            'Patient Name',
            'IC Number',
            'Phone No',
            'Gender',
            'Age',
            'Visit Setting',
            'Referral Source',
            'Triage Priority',
            'Diabetes Type',
            'Duration (Years)',
            'Reason for Referral',
            'Weight (kg)',
            'BMI',
            'BP',
            'HbA1c (%)',
            'eGFR',
            'Current Meds',
            'Insulin Technique',
            'Adherence Issue',
            'Lipodystrophy',
            'Dietary Pattern',
            'Smoking Status',
            'Hypoglycemia History',
            'SMBG Frequency',
            'Topics Covered',
            'SMART Goal',
            'Next Follow Up',
            'Educator Name'
        ];

        $callback = function () use ($patients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($patients as $patient) {
                fputcsv($file, [
                    $patient->date_of_visit,
                    $patient->patient_name,
                    $patient->ic_number,
                    $patient->phone_no,
                    $patient->gender,
                    $patient->age,
                    $patient->visit_setting,
                    $patient->referral_source,
                    $patient->triage_priority,
                    $patient->diabetes_type,
                    $patient->duration_years,
                    $patient->reason_for_referral,
                    $patient->weight_kg,
                    $patient->bmi,
                    $patient->bp,
                    $patient->hba1c,
                    $patient->egfr,
                    $patient->current_meds,
                    $patient->insulin_technique,
                    $patient->adherence_issue,
                    $patient->lipodystrophy,
                    $patient->dietary_pattern,
                    $patient->smoking_status,
                    $patient->hypoglycemia_history,
                    $patient->smbg_frequency,
                    $patient->topics_covered,
                    $patient->smart_goal,
                    $patient->next_follow_up,
                    $patient->educator_name,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export all patients as HL7 batch
     */
    public function exportHl7()
    {
        $patients = Patient::all();
        $hl7Messages = $patients->map(fn($p) => $p->generateHL7Message())->implode("\r\r");

        return response($hl7Messages)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="batch_export.hl7"');
    }

    /**
     * Backup all data as JSON
     */
    public function backup()
    {
        $patients = Patient::all();
        return response()->json($patients)
            ->header('Content-Disposition', 'attachment; filename="DiabEduc_Backup_' . now()->format('Y-m-d') . '.json"');
    }

    /**
     * Restore data from JSON backup
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json',
        ]);

        try {
            $data = json_decode(file_get_contents($request->file('backup_file')->getRealPath()), true);

            if (!is_array($data)) {
                return back()->with('error', 'Invalid backup file.');
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Patient::truncate();

            foreach ($data as $patientData) {
                Patient::create([
                    'date_of_visit' => $patientData['date_of_visit'] ?? now(),
                    'patient_name' => $patientData['patient_name'] ?? '',
                    'ic_number' => $patientData['ic_number'] ?? '',
                    'phone_no' => $patientData['phone_no'] ?? null,
                    'gender' => $patientData['gender'] ?? 'Male',
                    'age' => $patientData['age'] ?? null,
                    'visit_setting' => $patientData['visit_setting'] ?? 'Outpatient',
                    'referral_source' => $patientData['referral_source'] ?? null,
                    'triage_priority' => $patientData['triage_priority'] ?? 'Priority 2 (Semi-Urgent)',
                    'diabetes_type' => $patientData['diabetes_type'] ?? 'T2DM',
                    'duration_years' => $patientData['duration_years'] ?? null,
                    'reason_for_referral' => $patientData['reason_for_referral'] ?? null,
                    'weight_kg' => $patientData['weight_kg'] ?? null,
                    'bmi' => $patientData['bmi'] ?? null,
                    'bp' => $patientData['bp'] ?? null,
                    'hba1c' => $patientData['hba1c'] ?? null,
                    'egfr' => $patientData['egfr'] ?? null,
                    'current_meds' => $patientData['current_meds'] ?? null,
                    'insulin_technique' => $patientData['insulin_technique'] ?? null,
                    'adherence_issue' => $patientData['adherence_issue'] ?? null,
                    'lipodystrophy' => $patientData['lipodystrophy'] ?? null,
                    'dietary_pattern' => $patientData['dietary_pattern'] ?? null,
                    'smoking_status' => $patientData['smoking_status'] ?? 'Non-Smoker',
                    'hypoglycemia_history' => $patientData['hypoglycemia_history'] ?? null,
                    'smbg_frequency' => $patientData['smbg_frequency'] ?? null,
                    'topics_covered' => $patientData['topics_covered'] ?? null,
                    'smart_goal' => $patientData['smart_goal'] ?? null,
                    'next_follow_up' => $patientData['next_follow_up'] ?? null,
                    'educator_name' => $patientData['educator_name'] ?? 'SN Sarah',
                ]);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return redirect()->route('patients.index')
                ->with('success', 'System restored successfully! ' . count($data) . ' records imported.');
        } catch (\Exception $e) {
            Log::error('Error restoring backup: ' . $e->getMessage());
            return back()->with('error', 'Failed to restore backup: ' . $e->getMessage());
        }
    }

    /**
     * Reset all data
     */
    public function reset()
    {
        try {
            Patient::truncate();
            return redirect()->route('patients.index')
                ->with('success', 'System has been reset. All patient records deleted.');
        } catch (\Exception $e) {
            Log::error('Error resetting system: ' . $e->getMessage());
            return back()->with('error', 'Failed to reset system.');
        }
    }
}
