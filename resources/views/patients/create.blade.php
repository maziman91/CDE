@extends('layouts.dashboard')

@section('title', 'New Patient - DiabEduc')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('patients.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">New Patient Entry</h1>
    </div>
@endsection

@section('dashboard_content')
    <div class="max-w-5xl mx-auto">
        <form action="{{ route('patients.store') }}" method="POST"
            class="bg-white rounded-xl border border-gray-200 shadow-sm">
            @csrf

            <!-- Form Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                <h2 class="text-lg font-semibold text-gray-800">Patient Information</h2>
                <p class="text-sm text-gray-500 mt-1">Enter the patient's details below.</p>
            </div>

            <!-- Form Body -->
            <div class="p-8">
                <!-- Demographics Section -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-4">Demographics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Visit <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="date_of_visit"
                                value="{{ old('date_of_visit', now()->format('Y-m-d')) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('date_of_visit')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Patient Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="patient_name"
                                value="{{ old('patient_name', $screeningData['name'] ?? '') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter full name">
                            @error('patient_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">IC Number <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="ic_number"
                                value="{{ old('ic_number', $screeningData['ic_number'] ?? '') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., 800101-01-5566">
                            @error('ic_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="phone_no" value="{{ old('phone_no') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., 012-3456789">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender <span
                                    class="text-red-500">*</span></label>
                            <select name="gender"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="Male" {{ old('gender', $screeningData['gender'] ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $screeningData['gender'] ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                            <input type="number" name="age" value="{{ old('age', $screeningData['age'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Years">
                        </div>
                    </div>
                </div>

                <!-- Visit Information Section -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-4">Visit Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Visit Setting <span
                                    class="text-red-500">*</span></label>
                            <select name="visit_setting"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="Outpatient" {{ old('visit_setting') == 'Outpatient' ? 'selected' : '' }}>
                                    Outpatient</option>
                                <option value="Inpatient" {{ old('visit_setting') == 'Inpatient' ? 'selected' : '' }}>
                                    Inpatient</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Referral Source</label>
                            <input type="text" name="referral_source" value="{{ old('referral_source') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., Dr. Ahmad">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Triage Priority <span
                                    class="text-red-500">*</span></label>
                            <select name="triage_priority"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="Priority 1 (Urgent)" {{ old('triage_priority') == 'Priority 1 (Urgent)' ? 'selected' : '' }}>Priority 1 (Urgent)</option>
                                <option value="Priority 2 (Semi-Urgent)" {{ old('triage_priority') == 'Priority 2 (Semi-Urgent)' ? 'selected' : '' }}>Priority 2 (Semi-Urgent)</option>
                                <option value="Priority 3 (Non-Urgent)" {{ old('triage_priority') == 'Priority 3 (Non-Urgent)' ? 'selected' : '' }}>Priority 3 (Non-Urgent)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diabetes Type <span
                                    class="text-red-500">*</span></label>
                            <select name="diabetes_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="T2DM" {{ old('diabetes_type') == 'T2DM' ? 'selected' : '' }}>T2DM</option>
                                <option value="T1DM" {{ old('diabetes_type') == 'T1DM' ? 'selected' : '' }}>T1DM</option>
                                <option value="GDM" {{ old('diabetes_type') == 'GDM' ? 'selected' : '' }}>GDM</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Duration (Years)</label>
                            <input type="number" name="duration_years" value="{{ old('duration_years') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Years since diagnosis">
                        </div>
                    </div>
                </div>

                <!-- Clinical Data Section -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-4">Clinical Data</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight_kg" value="{{ old('weight_kg') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="kg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">BMI</label>
                            <input type="number" step="0.1" name="bmi" value="{{ old('bmi', $screeningData['bmi'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="kg/m²">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Blood Pressure</label>
                            <input type="text" name="bp" value="{{ old('bp') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., 120/80">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">HbA1c (%)</label>
                            <input type="number" step="0.1" name="hba1c" value="{{ old('hba1c') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-red-600 font-semibold"
                                placeholder="e.g., 7.5">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">eGFR</label>
                            <input type="number" name="egfr" value="{{ old('egfr') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="mL/min">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                        <textarea name="current_meds" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="List current medications...">{{ old('current_meds') }}</textarea>
                    </div>
                </div>

                <!-- Management Plan Section -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-4">Management Plan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Insulin Technique</label>
                            <input type="text" name="insulin_technique" value="{{ old('insulin_technique') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adherence Issue</label>
                            <input type="text" name="adherence_issue" value="{{ old('adherence_issue') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dietary Pattern</label>
                            <input type="text" name="dietary_pattern" value="{{ old('dietary_pattern') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Smoking Status</label>
                            <select name="smoking_status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="Non-Smoker" {{ old('smoking_status') == 'Non-Smoker' ? 'selected' : '' }}>
                                    Non-Smoker</option>
                                <option value="Smoker" {{ old('smoking_status') == 'Smoker' ? 'selected' : '' }}>Smoker
                                </option>
                                <option value="Ex-Smoker" {{ old('smoking_status') == 'Ex-Smoker' ? 'selected' : '' }}>
                                    Ex-Smoker</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMART Goal</label>
                        <input type="text" name="smart_goal" value="{{ old('smart_goal') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-blue-50"
                            placeholder="Specific, Measurable, Achievable, Relevant, Time-bound goal">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Next Follow Up</label>
                            <input type="date" name="next_follow_up" value="{{ old('next_follow_up') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Educator Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="educator_name" value="{{ old('educator_name', 'SN Sarah') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-8 py-6 border-t border-gray-200 bg-gray-50 rounded-b-xl flex items-center justify-end gap-4">
                <a href="{{ route('patients.index') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Save Patient
                </button>
            </div>
        </form>
    </div>
@endsection