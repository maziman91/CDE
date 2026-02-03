@extends('layouts.dashboard')

@section('title', 'Screening Results - DiabEduc')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('screenings.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">Assessment Results</h1>
    </div>
@endsection

@section('dashboard_content')
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Result Card -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Left Side: Risk Level -->
                <div
                    class="p-12 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100 text-center">
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2">Calculated Risk</span>
                    <div class="text-5xl font-black mb-4 {{ $screening->risk_color }}">
                        {{ $screening->risk_level }}
                    </div>
                    <div class="text-gray-600 font-medium">
                        Total Score: <span class="text-gray-900 font-bold text-xl">{{ $screening->total_score }}</span> / 26
                    </div>

                    <!-- Simple Visual Gauge -->
                    <div class="w-full h-4 bg-gray-100 rounded-full mt-8 overflow-hidden flex">
                        <div class="h-full bg-green-500 transition-all duration-1000"
                            style="width: {{ min(($screening->total_score / 26) * 100, 33) }}%"></div>
                        <div class="h-full bg-yellow-500 transition-all duration-1000"
                            style="width: {{ $screening->total_score > 7 ? min((($screening->total_score - 7) / 26) * 100, 33) : 0 }}%">
                        </div>
                        <div class="h-full bg-red-500 transition-all duration-1000"
                            style="width: {{ $screening->total_score > 14 ? min((($screening->total_score - 14) / 26) * 100, 34) : 0 }}%">
                        </div>
                    </div>
                    <div
                        class="flex justify-between w-full mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                        <span>Low</span>
                        <span>Moderate</span>
                        <span>High Risk</span>
                    </div>
                </div>

                <!-- Right Side: Details -->
                <div class="p-12 space-y-6 bg-gray-50">
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-gray-500 uppercase">Patient Information</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $screening->name }}</p>
                        <p class="text-gray-600">{{ $screening->gender }} • {{ $screening->age }} years old</p>
                        @if($screening->ic_number)
                            <p class="text-xs text-gray-400 mt-1">ID: {{ $screening->ic_number }}</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl shadow-xs border border-gray-200">
                            <p class="text-[10px] uppercase font-bold text-gray-400">BMI</p>
                            <p class="text-lg font-bold text-gray-800">{{ $screening->bmi }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-xs border border-gray-200">
                            <p class="text-[10px] uppercase font-bold text-gray-400">Activity</p>
                            <p class="text-lg font-bold text-gray-800">
                                {{ $screening->physical_activity ? 'Active' : 'Sedentary' }}</p>
                        </div>
                    </div>

                    @if($screening->risk_level !== 'Low')
                        <div class="p-4 bg-white rounded-xl border-l-4 border-blue-500 shadow-sm">
                            <p class="text-sm font-bold text-blue-700 mb-1">Recommendation</p>
                            <p class="text-xs text-gray-600">Consider clinical diagnostic testing (HbA1c or Oral Glucose
                                Tolerance Test) for this individual.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
            <a href="{{ route('screenings.index') }}"
                class="w-full sm:w-auto px-8 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition">
                Back to Registry
            </a>
            <button onclick="window.print()"
                class="w-full sm:w-auto px-8 py-3 bg-gray-800 text-white rounded-xl hover:bg-gray-900 font-bold shadow-lg transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-print"></i> Print Assessment
            </button>
            @if($screening->risk_level === 'High' || $screening->risk_level === 'Moderate')
                <a href="{{ route('screenings.convert', $screening) }}"
                    class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Convert to Patient Registry
                </a>
            @endif
        </div>
    </div>
@endsection