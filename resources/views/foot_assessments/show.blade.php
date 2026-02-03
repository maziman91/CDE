@extends('layouts.dashboard')

@section('title', 'Assessment Details - DiabEduc')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('foot_assessments.index', ['patient_id' => $footAssessment->patient_id]) }}"
            class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">Clinical Assessment Detail</h1>
    </div>
@endsection

@section('dashboard_content')
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Summary Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Identification</h3>
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 font-bold">
                            {{ substr($footAssessment->patient->patient_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ $footAssessment->patient->patient_name }}</p>
                            <p class="text-xs text-gray-500">IC: {{ $footAssessment->patient->ic_number }}</p>
                        </div>
                    </div>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Risk Stratification</h3>
                    @php $badge = $footAssessment->risk_badge; @endphp
                    <div class="p-4 rounded-xl {{ $badge['color'] }} text-center">
                        <p class="text-[10px] uppercase font-black opacity-60 mb-1">Assessed Level</p>
                        <p class="text-xl font-black mb-1">{{ $badge['label'] }}</p>
                        <p class="text-xs font-bold">Category {{ $footAssessment->risk_category }}</p>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs text-gray-400 font-bold mb-2">ASSESSMENT DATE</p>
                        <p class="text-gray-700 font-medium">{{ $footAssessment->assessment_date->format('F d, Y') }}</p>
                    </div>
                </div>

                <div class="bg-gray-800 p-6 rounded-xl text-white shadow-xl">
                    <h4 class="font-bold flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-lightbulb text-yellow-400"></i>
                        Care Plan
                    </h4>
                    <div class="space-y-4 text-xs leading-relaxed text-gray-300">
                        @if($footAssessment->risk_category == '0')
                            <p>• Daily self-inspection of feet.</p>
                            <p>• Proper footwear selection advice.</p>
                            <p>• Annual professional foot screening.</p>
                        @elseif($footAssessment->risk_category == '1')
                            <p>• Intensive education on foot inspection.</p>
                            <p>• Footwear evaluation by professional.</p>
                            <p>• Screening every 3-6 months.</p>
                        @elseif($footAssessment->risk_category == '2')
                            <p>• URGENT Referral to Podiatry/Wound Care.</p>
                            <p>• Diabetic therapeutic footwear indicated.</p>
                            <p>• Daily monitoring by family/caregiver.</p>
                            <p>• Clinical review every 1-2 months.</p>
                        @elseif($footAssessment->risk_category == '3')
                            <p class="text-white font-bold underline mb-2">CRITICAL RISK - URGENT INTERVENTION</p>
                            <p>• Multidisciplinary foot team referral within 24h.</p>
                            <p>• Absolute offloading if current ulcer present.</p>
                            <p>• Aggressive vascular follow-up if PAD present.</p>
                            <p>• Clinical review every 1-4 weeks.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detailed Comparison -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="grid grid-cols-2 text-center font-bold text-xs uppercase tracking-widest">
                        <div class="p-4 bg-blue-600 text-white">Right Foot Findings</div>
                        <div class="p-4 bg-purple-600 text-white">Left Foot Findings</div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <!-- Pulses DP -->
                        <div class="grid grid-cols-2">
                            <div class="p-8 border-r border-gray-100 flex flex-col items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mb-1">Pulse (DP)</span>
                                <span
                                    class="font-bold @if($footAssessment->r_pulse_dp != 'Present') text-orange-600 @else text-gray-800 @endif">
                                    {{ $footAssessment->r_pulse_dp }}
                                </span>
                            </div>
                            <div class="p-8 flex flex-col items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mb-1">Pulse (DP)</span>
                                <span
                                    class="font-bold @if($footAssessment->l_pulse_dp != 'Present') text-orange-600 @else text-gray-800 @endif">
                                    {{ $footAssessment->l_pulse_dp }}
                                </span>
                            </div>
                        </div>
                        <!-- Pulses PT -->
                        <div class="grid grid-cols-2">
                            <div class="p-8 border-r border-gray-100 flex flex-col items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mb-1">Pulse (PT)</span>
                                <span
                                    class="font-bold @if($footAssessment->r_pulse_pt != 'Present') text-orange-600 @else text-gray-800 @endif">
                                    {{ $footAssessment->r_pulse_pt }}
                                </span>
                            </div>
                            <div class="p-8 flex flex-col items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mb-1">Pulse (PT)</span>
                                <span
                                    class="font-bold @if($footAssessment->l_pulse_pt != 'Present') text-orange-600 @else text-gray-800 @endif">
                                    {{ $footAssessment->l_pulse_pt }}
                                </span>
                            </div>
                        </div>
                        <!-- Sensation -->
                        <div class="grid grid-cols-2">
                            <div class="p-8 border-r border-gray-100 flex flex-col items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mb-2">Protective Sensation</span>
                                @if($footAssessment->r_sensation)
                                    <span
                                        class="px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-lg border border-green-100">INTACT</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-lg border border-red-100 italic">LOSS
                                        (LOPS)</span>
                                @endif
                            </div>
                            <div class="p-8 flex flex-col items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mb-2">Protective Sensation</span>
                                @if($footAssessment->l_sensation)
                                    <span
                                        class="px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-lg border border-green-100">INTACT</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-lg border border-red-100 italic">LOSS
                                        (LOPS)</span>
                                @endif
                            </div>
                        </div>
                        <!-- Physical Parameters (Deformity, Callus) -->
                        <div class="p-8 bg-gray-50/50">
                            <div class="grid grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <h4 class="text-[10px] font-black text-gray-400 uppercase text-center">Structural
                                        Findings (R)</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->r_deformity) bg-orange-600 text-white @else bg-white text-gray-400 border border-gray-100 @endif">DEFORMITY</span>
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->r_callus) bg-orange-600 text-white @else bg-white text-gray-400 border border-gray-100 @endif">CALLUS</span>
                                    </div>
                                </div>
                                <div class="space-y-4 border-l border-gray-200">
                                    <h4 class="text-[10px] font-black text-gray-400 uppercase text-center">Structural
                                        Findings (L)</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->l_deformity) bg-orange-600 text-white @else bg-white text-gray-400 border border-gray-100 @endif">DEFORMITY</span>
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->l_callus) bg-orange-600 text-white @else bg-white text-gray-400 border border-gray-100 @endif">CALLUS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- High Risk Signs (Ulcer, Amp) -->
                        <div class="p-8 bg-red-50/20">
                            <div class="grid grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <h4 class="text-[10px] font-black text-red-400 uppercase text-center">History (R)</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->r_ulcer) bg-red-600 text-white @else bg-white text-gray-300 border border-gray-100 @endif">ULCER</span>
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->r_amputation) bg-red-900 text-white @else bg-white text-gray-300 border border-gray-100 @endif">AMPUTATION</span>
                                    </div>
                                </div>
                                <div class="space-y-4 border-l border-red-100">
                                    <h4 class="text-[10px] font-black text-red-400 uppercase text-center">History (L)</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->l_ulcer) bg-red-600 text-white @else bg-white text-gray-300 border border-gray-100 @endif">ULCER</span>
                                        <span
                                            class="px-3 py-1 rounded text-[10px] font-bold @if($footAssessment->l_amputation) bg-red-900 text-white @else bg-white text-gray-300 border border-gray-100 @endif">AMPUTATION</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($footAssessment->remarks)
                        <div class="p-8 border-t border-gray-100">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase mb-2">Clinical Remarks</h4>
                            <p class="text-sm text-gray-600 italic">"{{ $footAssessment->remarks }}"</p>
                        </div>
                    @endif
                </div>

                <div class="flex gap-4">
                    <button onclick="window.print()"
                        class="flex-1 px-6 py-3 bg-gray-800 text-white rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-gray-900 transition shadow-lg">
                        <i class="fa-solid fa-print"></i> Print Clinical Record
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection