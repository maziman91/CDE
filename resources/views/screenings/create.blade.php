@extends('layouts.dashboard')

@section('title', 'New Screening - DiabEduc')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">New Risk Assessment</h1>
@endsection

@section('dashboard_content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-blue-600 px-8 py-6 text-white text-center">
                <h2 class="text-2xl font-bold">Type 2 Diabetes Risk Assessment</h2>
                <p class="text-blue-100 mt-1">Answer the following questions to estimate the risk of developing diabetes.
                </p>
            </div>

            <form action="{{ route('screenings.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <!-- Personal Info -->
                <section class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm">1</span>
                        Basic Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IC / ID Number (Optional)</label>
                            <input type="text" name="ic_number"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                <input type="number" name="age" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <select name="gender" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">BMI (Body Mass Index)</label>
                            <input type="number" step="0.1" name="bmi" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g. 24.5">
                        </div>
                    </div>
                </section>

                <hr class="border-gray-100">

                <!-- Lifestyle & History -->
                <section class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm">2</span>
                        Clinical & Lifestyle Factors
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Physical Activity -->
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-3">Do you perform at least 30 mins of physical
                                activity daily?</p>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="physical_activity" value="1" required class="sr-only peer">
                                    <div
                                        class="p-3 text-center border rounded-lg peer-checked:border-blue-600 peer-checked:bg-blue-50 transition font-medium">
                                        Yes</div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="physical_activity" value="0" class="sr-only peer">
                                    <div
                                        class="p-3 text-center border rounded-lg peer-checked:border-red-600 peer-checked:bg-red-50 transition font-medium">
                                        No</div>
                                </label>
                            </div>
                        </div>

                        <!-- Family History -->
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-3">Family history of diabetes (type 1 or type 2)?
                            </p>
                            <select name="family_history" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="none">No history</option>
                                <option value="distant">Yes: Grandparent, aunt, uncle or first cousin</option>
                                <option value="immediate">Yes: Parent, brother, sister or own child</option>
                            </select>
                        </div>

                        <!-- High Blood Pressure -->
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-3">Ever been told you have high blood pressure?
                            </p>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="history_high_bp" value="1" required class="sr-only peer">
                                    <div
                                        class="p-3 text-center border rounded-lg peer-checked:border-red-600 peer-checked:bg-red-50 transition font-medium">
                                        Yes</div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="history_high_bp" value="0" class="sr-only peer">
                                    <div
                                        class="p-3 text-center border rounded-lg peer-checked:border-blue-600 peer-checked:bg-blue-50 transition font-medium">
                                        No</div>
                                </label>
                            </div>
                        </div>

                        <!-- High Glucose -->
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-3">Found to have high blood glucose (e.g. during
                                pregnancy)?</p>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="history_high_glucose" value="1" required class="sr-only peer">
                                    <div
                                        class="p-3 text-center border rounded-lg peer-checked:border-red-600 peer-checked:bg-red-50 transition font-medium">
                                        Yes</div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="history_high_glucose" value="0" class="sr-only peer">
                                    <div
                                        class="p-3 text-center border rounded-lg peer-checked:border-blue-600 peer-checked:bg-blue-50 transition font-medium">
                                        No</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="pt-6 flex gap-4">
                    <a href="{{ route('screenings.index') }}"
                        class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 text-center font-bold transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold shadow-lg hover:shadow-xl transition">
                        Finish & Calculate Risk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection