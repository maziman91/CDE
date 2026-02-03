@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Shared Sidebar -->
        @include('partials.sidebar', ['class' => 'hidden md:flex'])

        <!-- Main Content Shell -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header Section -->
            @hasSection('header')
                <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                    @yield('header')
                </header>
            @endif

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                @yield('dashboard_content')
            </div>
        </main>
    </div>
@endsection