@extends('layouts.app')

@section('title', 'Diabetes Educator Clinic Management System')

@section('content')
    <!-- Main App -->
    <div id="main-app" class="w-full h-full">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col hidden md:flex">
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <i class="fa-solid fa-heart-pulse text-blue-600 text-xl mr-3"></i>
                <span class="font-bold text-lg tracking-tight">DiabEduc</span>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4">
                <a href="{{ route('patients.index') }}" class="sidebar-link active flex items-center px-6 py-3 text-gray-600">
                    <i class="fa-solid fa-chart-pie w-6"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('patients.index') }}#patients" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <i class="fa-solid fa-users w-6"></i>
                    <span class="font-medium">Patient Registry</span>
                </a>
                <div class="my-4 border-t border-gray-100"></div>
                <a href="{{ route('patients.index') }}#system" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <i class="fa-solid fa-server w-6"></i>
                    <span class="font-medium">System & Data</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">SN</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">SN Sarah</p>
                        <p class="text-xs text-gray-500">Educator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 md:px-8">
                <div class="md:hidden flex items-center">
                    <button class="text-gray-500 hover:text-gray-700 mr-4"><i class="fa-solid fa-bars"></i></button>
                    <span class="font-bold text-lg">DiabEduc</span>
                </div>
                <h2 class="text-xl font-bold text-gray-800 hidden md:block">Dashboard</h2>
                <div class="flex items-center gap-4">
                    <a href="{{ route('export.csv') }}" class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                        <i class="fa-solid fa-download"></i> Export CSV
                    </a>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto bg-gray-50 p-6 md:p-8" id="content-area">
                
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Total Patients</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</h3>
                            </div>
                            <span class="p-2 bg-blue-50 rounded-lg text-blue-600"><i class="fa-solid fa-users"></i></span>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Avg HbA1c</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['avg_hba1c'] ?? 0, 1) }}%</h3>
                            </div>
                            <span class="p-2 bg-purple-50 rounded-lg text-purple-600"><i class="fa-solid fa-droplet"></i></span>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Uncontrolled (>8%)</p>
                                <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $stats['high_risk'] }}</h3>
                            </div>
                            <span class="p-2 bg-red-50 rounded-lg text-red-600"><i class="fa-solid fa-triangle-exclamation"></i></span>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Avg BMI</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['avg_bmi'] ?? 0, 1) }}</h3>
                            </div>
                            <span class="p-2 bg-green-50 rounded-lg text-green-600"><i class="fa-solid fa-weight-scale"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Patients Section -->
                <div id="patients" class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-full mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h3 class="font-bold text-gray-800 text-lg">Patient Registry</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('patients.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> New Patient
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto custom-scroll flex-1">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 font-medium sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">IC Number</th>
                                    <th class="px-6 py-3">Gender</th>
                                    <th class="px-6 py-3">Visit Date</th>
                                    <th class="px-6 py-3">HbA1c</th>
                                    <th class="px-6 py-3">Next Follow Up</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($patients->take(10) as $patient)
                                    <tr class="bg-white border-b hover:bg-blue-50 cursor-pointer transition">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $patient->patient_name }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $patient->ic_number }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $patient->gender }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $patient->date_of_visit }}</td>
                                        <td class="px-6 py-4 font-bold {{ $patient->hba1c_color }}">{{ $patient->hba1c }}%</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $patient->next_follow_up }}</td>
                                        <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                            <a href="{{ route('patients.edit', $patient) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded transition" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                            <a href="{{ route('patients.hl7', $patient) }}" class="p-2 text-purple-600 hover:bg-purple-100 rounded transition" title="HL7"><i class="fa-solid fa-code"></i></a>
                                            <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this patient record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded transition" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No patients found. Add your first patient to get started.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-3 border-t border-gray-100 text-xs text-gray-500 flex justify-between">
                        <span>Showing {{ $patients->count() }} entries</span>
                    </div>
                </div>

                <!-- System & Data Section -->
                <div id="system" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-database text-blue-600"></i> Backup & Restore
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-5 border border-gray-200 rounded-lg bg-gray-50">
                            <h4 class="font-semibold text-gray-700 mb-2">Backup System Data</h4>
                            <p class="text-sm text-gray-500 mb-4">Download a full JSON backup of all patient records and settings.</p>
                            <a href="{{ route('backup') }}" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 font-medium transition flex justify-center items-center gap-2">
                                <i class="fa-solid fa-download"></i> Download Backup (.json)
                            </a>
                        </div>
                        <div class="p-5 border border-gray-200 rounded-lg bg-gray-50">
                            <h4 class="font-semibold text-gray-700 mb-2">Restore Data</h4>
                            <p class="text-sm text-gray-500 mb-4">Restore system from a previous backup file. <strong class="text-red-600">Warning: Replaces current data.</strong></p>
                            <form action="{{ route('restore') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="backup_file" id="restore-file-input" accept=".json" class="hidden" onchange="this.form.submit()">
                                <label for="restore-file-input" class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition flex justify-center items-center gap-2 cursor-pointer">
                                    <i class="fa-solid fa-upload"></i> Select Backup File
                                </label>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- HL7 Interoperability -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-network-wired text-purple-600"></i> HL7 Interoperability (v2.5)
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Generate standard HL7 ORU^R01 (Observation Result) messages for integration with Hospital Information Systems (HIS).</p>
                    
                    <div class="p-4 bg-gray-900 rounded-lg mb-4 overflow-x-auto">
                        <pre class="hl7-block text-xs text-green-400">
MSH|^~\&|DiabEduc|Klinik|HIS|Klinik|{{ now()->format('YmdHis') }}||ORU^R01|MSG{{ rand(10000, 99999) }}|P|2.5
PID|1||800101-11-5566||Abu^Ali||19800101|M
PV1|1|O|Outpatient^Klinik Kesihatan||||||||||||||||{{ now()->format('Ymd') }}
OBX|1|NM|4548-4^HbA1c||10.2|%||||F
OBX|2|NM|39156-5^BMI||29.5|kg/m2||||F
OBX|3|NM|29463-7^Body Weight||85.5|kg||||F
OBX|4|NM|33914-3^eGFR||65|mL/min||||F
                        </pre>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('export.hl7') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition flex items-center gap-2">
                            <i class="fa-solid fa-file-code"></i> Download Batch HL7
                        </a>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-xl border border-red-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-red-600 mb-2">Danger Zone</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">Permanently delete all patient records and reset the system.</p>
                        <form action="{{ route('reset') }}" method="POST" onsubmit="return confirm('DANGER: This will delete ALL patient records. This cannot be undone. Are you sure?')">
                            @csrf
                            @method('POST')
                            <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 border border-red-100 rounded-lg hover:bg-red-100 font-medium transition">
                                Reset System
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>
@endsection
