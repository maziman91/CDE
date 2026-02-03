@extends('layouts.dashboard')

@section('title', 'Dashboard - DiabEduc')

@section('header')
    <div class="flex items-center gap-4">
        <h1 class="text-xl font-semibold text-gray-800">Overview</h1>
    </div>
@endsection

@section('dashboard_content')
    <!-- Stats Cards -->
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

    <!-- Quick Actions or Recent Activity could go here -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('patients.create') }}"
                    class="flex flex-col items-center justify-center p-4 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                    <i class="fa-solid fa-user-plus text-2xl mb-2"></i>
                    <span class="font-medium">New Patient</span>
                </a>
                <a href="{{ route('export.csv') }}"
                    class="flex flex-col items-center justify-center p-4 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">
                    <i class="fa-solid fa-file-csv text-2xl mb-2"></i>
                    <span class="font-medium">Export CSV</span>
                </a>
            </div>
        </div>
    </div>
@endsection