@extends('layouts.dashboard')

@section('title', 'Diabetes Screening - DiabEduc')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">Diabetes Screening</h1>
    <a href="{{ route('screenings.create') }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> New Screening
    </a>
@endsection

@section('dashboard_content')
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-semibold text-gray-800">Recent Assessments</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Age/Gender</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Risk Score</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Risk Level</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Date</th>
                        <th class="px-6 py-3 text-right font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($screenings as $screening)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $screening->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $screening->age }}y / {{ $screening->gender }}</td>
                            <td class="px-6 py-4 text-gray-600 font-mono">{{ $screening->total_score }} points</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $screening->risk_color }}">
                                    {{ $screening->risk_level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $screening->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('screenings.show', $screening) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="View Results">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if($screening->risk_level === 'High' || $screening->risk_level === 'Moderate')
                                        <a href="{{ route('screenings.convert', $screening) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                            title="Convert to Patient">
                                            <i class="fa-solid fa-user-check"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('screenings.destroy', $screening) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete this record?')">
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
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p>No screenings found. Start by assessing a new individual.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($screenings->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $screenings->links() }}
            </div>
        @endif
    </div>
@endsection