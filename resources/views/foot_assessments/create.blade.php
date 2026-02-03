@extends('layouts.dashboard')

@section('title', 'Foot Assessment - DiabEduc')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('foot_assessments.index', ['patient_id' => $patient->id]) }}"
            class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">New Foot Assessment</h1>
    </div>
@endsection

@section('dashboard_content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="px-8 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-800">{{ $patient->patient_name }}</h2>
                    <p class="text-xs text-gray-500">IC: {{ $patient->ic_number }} | Age: {{ $patient->age }}</p>
                </div>
                <div class="flex items-center gap-4">
                    @if($patient->egfr)
                        <div class="text-right px-4 border-r border-gray-200">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Latest eGFR</p>
                            <p class="text-sm font-bold {{ $patient->egfr < 15 ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $patient->egfr }} <span class="text-[10px] font-normal text-gray-400">mL/min</span>
                            </p>
                        </div>
                    @endif
                    <div id="risk-preview" class="px-4 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                        Low Risk (Initial)
                    </div>
                </div>
            </div>

            <form action="{{ route('foot_assessments.store') }}" method="POST" class="p-8">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                <div class="mb-8 flex justify-end">
                    <div class="w-64">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assessment Date</label>
                        <input type="date" name="assessment_date" value="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Parameters Table -->
                    <div class="lg:col-span-2 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-4 text-left font-bold">Clinical Parameter</th>
                                    <th class="px-6 py-4 text-center font-bold bg-blue-50 text-blue-700">Right Foot</th>
                                    <th class="px-6 py-4 text-center font-bold bg-purple-50 text-purple-700">Left Foot</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 italic-radio">
                                <!-- Pulses DP -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-700">Pulse (Dorsalis Pedis)</td>
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center gap-4">
                                            @foreach(['Present', 'Reduced', 'Absent'] as $opt)
                                                <label class="flex flex-col items-center cursor-pointer group">
                                                    <input type="radio" name="r_pulse_dp" value="{{ $opt }}" {{ $opt == 'Present' ? 'checked' : '' }} class="sr-only peer">
                                                    <div
                                                        class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 transition">
                                                    </div>
                                                    <span
                                                        class="text-[10px] mt-1 text-gray-500 peer-checked:text-blue-700 font-bold uppercase">{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-purple-50/30">
                                        <div class="flex justify-center gap-4">
                                            @foreach(['Present', 'Reduced', 'Absent'] as $opt)
                                                <label class="flex flex-col items-center cursor-pointer group">
                                                    <input type="radio" name="l_pulse_dp" value="{{ $opt }}" {{ $opt == 'Present' ? 'checked' : '' }} class="sr-only peer">
                                                    <div
                                                        class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-purple-600 peer-checked:bg-purple-600 transition">
                                                    </div>
                                                    <span
                                                        class="text-[10px] mt-1 text-gray-500 peer-checked:text-purple-700 font-bold uppercase">{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <!-- Pulses PT -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-700">Pulse (Posterior Tibial)</td>
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center gap-4">
                                            @foreach(['Present', 'Reduced', 'Absent'] as $opt)
                                                <label class="flex flex-col items-center cursor-pointer group">
                                                    <input type="radio" name="r_pulse_pt" value="{{ $opt }}" {{ $opt == 'Present' ? 'checked' : '' }} class="sr-only peer">
                                                    <div
                                                        class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 transition">
                                                    </div>
                                                    <span
                                                        class="text-[10px] mt-1 text-gray-500 peer-checked:text-blue-700 font-bold uppercase">{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-purple-50/30">
                                        <div class="flex justify-center gap-4">
                                            @foreach(['Present', 'Reduced', 'Absent'] as $opt)
                                                <label class="flex flex-col items-center cursor-pointer group">
                                                    <input type="radio" name="l_pulse_pt" value="{{ $opt }}" {{ $opt == 'Present' ? 'checked' : '' }} class="sr-only peer">
                                                    <div
                                                        class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-purple-600 peer-checked:bg-purple-600 transition">
                                                    </div>
                                                    <span
                                                        class="text-[10px] mt-1 text-gray-500 peer-checked:text-purple-700 font-bold uppercase">{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <!-- Sensation -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-700">Protective Sensation (Monofilament)</td>
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_sensation" value="1" checked
                                                    class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition text-xs font-bold uppercase">
                                                    Intact</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_sensation" value="0" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600 transition text-xs font-bold uppercase">
                                                    Loss</div>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-purple-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_sensation" value="1" checked
                                                    class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition text-xs font-bold uppercase">
                                                    Intact</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_sensation" value="0" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600 transition text-xs font-bold uppercase">
                                                    Loss</div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Deformity -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-700">Foot Deformity / Charcot</td>
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_deformity" value="0" checked
                                                    class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_deformity" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-orange-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-purple-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_deformity" value="0" checked
                                                    class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_deformity" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-orange-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Callus -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-700">Callus / Pre-ulcerative lesion</td>
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_callus" value="0" checked class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_callus" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-orange-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-purple-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_callus" value="0" checked class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_callus" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-orange-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <!-- History of Ulcer -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-700">History of Foot Ulcer</td>
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_ulcer" value="0" checked class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_ulcer" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-red-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-purple-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_ulcer" value="0" checked class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_ulcer" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-red-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <!-- History of Amputation -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-700">History of Amputation</td>
                                    <td class="px-6 py-4 bg-blue-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_amputation" value="0" checked
                                                    class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="r_amputation" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-red-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-purple-50/30">
                                        <div class="flex justify-center gap-12">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_amputation" value="0" checked
                                                    class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-gray-400 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    No</div>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="l_amputation" value="1" class="peer sr-only">
                                                <div
                                                    class="px-4 py-1 rounded bg-white border border-gray-200 peer-checked:bg-red-600 peer-checked:text-white transition text-xs font-bold uppercase">
                                                    Yes</div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Remarks / Clinical Notes</label>
                        <textarea name="remarks" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Add any observation about skin condition, fungal infection, or nail health..."></textarea>
                    </div>
                </div>

                <div class="mt-12 flex gap-4">
                    <a href="{{ route('foot_assessments.index', ['patient_id' => $patient->id]) }}"
                        class="flex-1 px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 text-center font-bold text-gray-700 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold shadow-lg transition">
                        Finalize Assessment & Stratify Risk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection