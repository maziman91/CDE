@extends('layouts.dashboard')

@section('title', 'System & Data - DiabEduc')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">System & Data</h1>
@endsection

@section('dashboard_content')
    <!-- System & Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Backup & Restore -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-database text-blue-600"></i> Backup & Restore
            </h3>
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="font-medium text-gray-700 mb-1">Backup System Data</h4>
                    <p class="text-sm text-gray-500 mb-3">Download a full JSON backup of all patient records.</p>
                    <a href="{{ route('backup') }}"
                        class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 font-medium transition flex justify-center items-center gap-2">
                        <i class="fa-solid fa-download"></i> Download Backup (.json)
                    </a>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="font-medium text-gray-700 mb-1">Restore Data</h4>
                    <p class="text-sm text-gray-500 mb-3">Restore from a previous backup. <span
                            class="text-red-600 font-medium">Replaces current data.</span></p>
                    <form action="{{ route('restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="backup_file" id="restore-file" accept=".json" class="hidden"
                            onchange="this.form.submit()">
                        <label for="restore-file"
                            class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition flex justify-center items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-upload"></i> Select Backup File
                        </label>
                    </form>
                </div>
            </div>
        </div>

        <!-- HL7 Interoperability -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-network-wired text-purple-600"></i> HL7 Interoperability (v2.5)
            </h3>
            <p class="text-sm text-gray-500 mb-4">Generate HL7 ORU^R01 messages for HIS integration.</p>

            <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
                <pre class="text-xs text-green-400 font-mono whitespace-pre">MSH|^~\&|DiabEduc|Klinik|HIS|Klinik|{{ now()->format('YmdHis') }}||ORU^R01|MSG{{ rand(10000, 99999) }}|P|2.5
    PID|1||800101-11-5566||Abu^Ali||19800101|M
    PV1|1|O|Outpatient^Klinik||||||||||||||||{{ now()->format('Ymd') }}
    OBX|1|NM|4548-4^HbA1c||10.2|%||||F
    OBX|2|NM|39156-5^BMI||29.5|kg/m2||||F</pre>
            </div>

            <a href="{{ route('export.hl7') }}"
                class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition flex items-center gap-2 inline-flex">
                <i class="fa-solid fa-file-code"></i> Download Batch HL7
            </a>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white rounded-xl border border-red-200 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">Permanently delete all patient records and reset the system.</p>
            <form action="{{ route('reset') }}" method="POST"
                onsubmit="return confirm('WARNING: This will delete ALL patient records. This cannot be undone. Are you sure?')">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 font-medium transition">
                    Reset System
                </button>
            </form>
        </div>
    </div>
@endsection