@extends('layouts.app')

@section('title', 'Login - DiabEduc')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-50 to-blue-50">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-heart-pulse text-blue-600 text-3xl"></i>
                    </div>
                </div>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900">
                    DiabEduc
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Diabetes Center of Excellence
                </p>
            </div>

            <!-- Login Form -->
            <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
                @csrf

                @if(session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="appearance-none rounded-lg relative block w-full pl-10 px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                                placeholder="Email address" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none rounded-lg relative block w-full pl-10 px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                placeholder="Password">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-md hover:shadow-lg">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i
                                class="fa-solid fa-arrow-right-to-bracket text-blue-500 group-hover:text-blue-400 transition"></i>
                        </span>
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection