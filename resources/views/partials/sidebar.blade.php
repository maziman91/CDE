<aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col {{ $class ?? '' }}">
    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <i class="fa-solid fa-heart-pulse text-blue-600 text-xl mr-3"></i>
        <span class="font-bold text-xl text-gray-800">DiabEduc</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <a href="{{ route('patients.index') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('patients.index') ? 'text-gray-700 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 transition' }}">
            <i class="fa-solid fa-chart-pie w-6 text-gray-500"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('patients.index') }}#patients"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition">
            <i class="fa-solid fa-users w-6 text-gray-500"></i>
            <span class="font-medium">Patient Registry</span>
        </a>
        <a href="{{ route('patients.create') }}"
            class="flex items-center px-6 py-3 {{ request()->routeIs('patients.create') ? 'text-gray-700 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 transition' }}">
            <i class="fa-solid fa-user-plus w-6 text-gray-500"></i>
            <span class="font-medium">New Patient</span>
        </a>
        <a href="{{ route('patients.index') }}#system"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition">
            <i class="fa-solid fa-server w-6 text-gray-500"></i>
            <span class="font-medium">System & Data</span>
        </a>
    </nav>

    <!-- User Profile -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">SN
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">SN Sarah</p>
                <p class="text-xs text-gray-500">Diabetes Educator</p>
            </div>
        </div>
    </div>
</aside>