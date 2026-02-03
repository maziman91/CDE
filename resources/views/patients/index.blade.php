@extends('layouts.dashboard')

@section('title', 'Dashboard - DiabEduc')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800 hidden md:block">Dashboard</h1>
    <div class="flex items-center gap-4">
        <form action="{{ route('patients.index') }}" method="GET" class="relative">
            <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Name or IC..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
        </form>
        <a href="{{ route('export.csv') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
            <i class="fa-solid fa-download"></i> Export CSV
        </a>
    </div>
@endsection

@section('dashboard_content')
    <!-- Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Stats Cards (Only show if not searching) -->
    @if(!request('search'))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Patients -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Patients</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Avg HbA1c -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Avg HbA1c</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['avg_hba1c'] ?? 0, 1) }}%</h3>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-droplet text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Uncontrolled -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Uncontrolled (>8%)</p>
                    <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $stats['high_risk'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Avg BMI -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Avg BMI</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['avg_bmi'] ?? 0, 1) }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-weight-scale text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Patient Registry -->
    <div id="patients" class="bg-white rounded-xl border border-gray-200 shadow-sm mb-8">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">
                @if(request('search'))
                    Search Results for "{{ request('search') }}"
                @else
                    Patient Registry
                @endif
            </h3>
            <div class="flex gap-2">
                @if(request('search'))
                    <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                        Clear Search
                    </a>
                @endif
                <a href="{{ route('patients.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> New Patient
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">IC Number</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Gender</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Visit Date</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">HbA1c</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Next Follow Up</th>
                        <th class="px-6 py-3 text-right font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $patient->patient_name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $patient->ic_number }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $patient->gender }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $patient->date_of_visit ? $patient->date_of_visit->format('M d, Y') : '' }}</td>
                            <td class="px-6 py-4 font-semibold {{ $patient->hba1c_color }}">{{ $patient->hba1c }}%</td>
                            <td class="px-6 py-4 text-gray-600">{{ $patient->next_follow_up ? $patient->next_follow_up->format('M d, Y') : '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('patients.edit', $patient) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="{{ route('patients.hl7', $patient) }}" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition" title="Export HL7">
                                        <i class="fa-solid fa-code"></i>
                                    </a>
                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline" onsubmit="return confirm('Delete this patient record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                <p>No patients found. {{ request('search') ? 'Try a different search.' : 'Add your first patient to get started.' }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $patients->links() }}
        </div>
    </div>
@endsection