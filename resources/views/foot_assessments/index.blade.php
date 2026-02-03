@extends('layouts.dashboard')

@section('title', 'Foot Assessment History - DiabEduc')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('patients.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">Foot Assessment History</h1>
    </div>
    <a href="{{ route('foot_assessments.create', ['patient_id' => $patient->id]) }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> New Assessment
    </a>
@endsection

@section('dashboard_content')
    <div class="max-w-6xl mx-auto">
        <!-- Patient Info Summary -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-user text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $patient->patient_name }}</h2>
                    <p class="text-sm text-gray-500">IC: {{ $patient->ic_number }} | Gender: {{ $patient->gender }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Ongoing Care</p>
                <p class="text-sm font-medium text-gray-600">Monitoring Diabetic Foot Risk</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold text-gray-600">Date</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-600">Category</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-600">Risk Level</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-600">Observation</th>
                        <th class="px-6 py-4 text-right font-bold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($assessments as $assessment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $assessment->assessment_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-600 border border-gray-200">
                                    Cat {{ $assessment->risk_category }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php $badge = $assessment->risk_badge; @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge['color'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                {{ $assessment->remarks ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('foot_assessments.show', $assessment) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('foot_assessments.destroy', $assessment) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Delete this assessment record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="mb-2">
                                    <i class="fa-solid fa-notes-medical text-3xl text-gray-200"></i>
                                </div>
                                <p>No foot assessments recorded yet for this patient.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($assessments->hasPages())
                <div class="p-4 border-t border-gray-200">
                    {{ $assessments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection