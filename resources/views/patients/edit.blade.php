<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient - DiabEduc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    <div class="w-full h-full flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col hidden md:flex">
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <i class="fa-solid fa-heart-pulse text-blue-600 text-xl mr-3"></i>
                <span class="font-bold text-lg tracking-tight">DiabEduc</span>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4">
                <a href="{{ route('patients.index') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <i class="fa-solid fa-chart-pie w-6"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('patients.index') }}#patients" class="sidebar-link active flex items-center px-6 py-3 text-gray-600">
                    <i class="fa-solid fa-users w-6"></i>
                    <span class="font-medium">Patient Registry</span>
                </a>
                <a href="{{ route('patients.create') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <i class="fa-solid fa-user-plus w-6"></i>
                    <span class="font-medium">New Entry</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 md:px-8">
                <h2 class="text-xl font-bold text-gray-800">Edit Patient</h2>
            </header>

            <div class="flex-1 overflow-y-auto bg-gray-50 p-6 md:p-8">
                <div class="max-w-4xl mx-auto bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Edit Patient Record</h3>
                            <p class="text-sm text-gray-500">Update patient information.</p>
                        </div>
                        <a href="{{ route('patients.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Back to List</a>
                    </div>
                    
                    <form action="{{ route('patients.update', $patient) }}" method="POST" class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Section: Demographics -->
                        <div class="col-span-full border-b pb-2 mb-2"><h4 class="font-semibold text-blue-600">Demographics</h4></div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Date of Visit</label>
                            <input type="date" name="date_of_visit" value="{{ old('date_of_visit', $patient->date_of_visit) }}" required class="w-full p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('date_of_visit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Patient Name</label>
                            <input type="text" name="patient_name" value="{{ old('patient_name', $patient->patient_name) }}" required class="w-full p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('patient_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">IC Number</label>
                            <input type="text" name="ic_number" value="{{ old('ic_number', $patient->ic_number) }}" required class="w-full p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @error('ic_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Phone No</label>
                            <input type="text" name="phone_no" value="{{ old('phone_no', $patient->phone_no) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Gender</label>
                            <select name="gender" class="w-full p-2 border rounded-md bg-white">
                                <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Age</label>
                            <input type="number" name="age" value="{{ old('age', $patient->age) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <!-- Section: Visit Info -->
                        <div class="col-span-full border-b pb-2 mb-2 mt-4"><h4 class="font-semibold text-blue-600">Visit Information</h4></div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Visit Setting</label>
                            <select name="visit_setting" class="w-full p-2 border rounded-md bg-white">
                                <option value="Outpatient" {{ old('visit_setting', $patient->visit_setting) == 'Outpatient' ? 'selected' : '' }}>Outpatient</option>
                                <option value="Inpatient" {{ old('visit_setting', $patient->visit_setting) == 'Inpatient' ? 'selected' : '' }}>Inpatient</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Referral Source</label>
                            <input type="text" name="referral_source" value="{{ old('referral_source', $patient->referral_source) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Triage Priority</label>
                            <select name="triage_priority" class="w-full p-2 border rounded-md bg-white">
                                <option value="Priority 1 (Urgent)" {{ old('triage_priority', $patient->triage_priority) == 'Priority 1 (Urgent)' ? 'selected' : '' }}>Priority 1 (Urgent)</option>
                                <option value="Priority 2 (Semi-Urgent)" {{ old('triage_priority', $patient->triage_priority) == 'Priority 2 (Semi-Urgent)' ? 'selected' : '' }}>Priority 2 (Semi-Urgent)</option>
                                <option value="Priority 3 (Non-Urgent)" {{ old('triage_priority', $patient->triage_priority) == 'Priority 3 (Non-Urgent)' ? 'selected' : '' }}>Priority 3 (Non-Urgent)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Diabetes Type</label>
                            <select name="diabetes_type" class="w-full p-2 border rounded-md bg-white">
                                <option value="T2DM" {{ old('diabetes_type', $patient->diabetes_type) == 'T2DM' ? 'selected' : '' }}>T2DM</option>
                                <option value="T1DM" {{ old('diabetes_type', $patient->diabetes_type) == 'T1DM' ? 'selected' : '' }}>T1DM</option>
                                <option value="GDM" {{ old('diabetes_type', $patient->diabetes_type) == 'GDM' ? 'selected' : '' }}>GDM</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Duration (Years)</label>
                            <input type="number" name="duration_years" value="{{ old('duration_years', $patient->duration_years) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <!-- Section: Clinical -->
                        <div class="col-span-full border-b pb-2 mb-2 mt-4"><h4 class="font-semibold text-blue-600">Clinical Data</h4></div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight_kg" value="{{ old('weight_kg', $patient->weight_kg) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">BMI</label>
                            <input type="number" step="0.1" name="bmi" value="{{ old('bmi', $patient->bmi) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">BP (mmHg)</label>
                            <input type="text" name="bp" placeholder="120/80" value="{{ old('bp', $patient->bp) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">HbA1c (%)</label>
                            <input type="number" step="0.1" name="hba1c" value="{{ old('hba1c', $patient->hba1c) }}" class="w-full p-2 border rounded-md text-red-600 font-bold">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">eGFR</label>
                            <input type="number" name="egfr" value="{{ old('egfr', $patient->egfr) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div class="col-span-full">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Current Meds</label>
                            <textarea name="current_meds" rows="2" class="w-full p-2 border rounded-md">{{ old('current_meds', $patient->current_meds) }}</textarea>
                        </div>

                        <!-- Section: Lifestyle & Plan -->
                        <div class="col-span-full border-b pb-2 mb-2 mt-4"><h4 class="font-semibold text-blue-600">Lifestyle & Management</h4></div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Insulin Technique</label>
                            <input type="text" name="insulin_technique" value="{{ old('insulin_technique', $patient->insulin_technique) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Adherence Issue</label>
                            <input type="text" name="adherence_issue" value="{{ old('adherence_issue', $patient->adherence_issue) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Dietary Pattern</label>
                            <input type="text" name="dietary_pattern" value="{{ old('dietary_pattern', $patient->dietary_pattern) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Smoking Status</label>
                            <select name="smoking_status" class="w-full p-2 border rounded-md bg-white">
                                <option value="Non-Smoker" {{ old('smoking_status', $patient->smoking_status) == 'Non-Smoker' ? 'selected' : '' }}>Non-Smoker</option>
                                <option value="Smoker" {{ old('smoking_status', $patient->smoking_status) == 'Smoker' ? 'selected' : '' }}>Smoker</option>
                                <option value="Ex-Smoker" {{ old('smoking_status', $patient->smoking_status) == 'Ex-Smoker' ? 'selected' : '' }}>Ex-Smoker</option>
                            </select>
                        </div>

                        <div class="col-span-full">
                            <label class="block text-xs font-medium text-gray-700 mb-1">SMART Goal</label>
                            <input type="text" name="smart_goal" value="{{ old('smart_goal', $patient->smart_goal) }}" class="w-full p-2 border rounded-md bg-blue-50">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Next Follow Up</label>
                            <input type="date" name="next_follow_up" value="{{ old('next_follow_up', $patient->next_follow_up) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Educator Name</label>
                            <input type="text" name="educator_name" value="{{ old('educator_name', $patient->educator_name) }}" class="w-full p-2 border rounded-md">
                        </div>

                        <div class="col-span-full pt-4 flex gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium shadow-md">Update Record</button>
                            <a href="{{ route('patients.index') }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 font-medium text-center">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
