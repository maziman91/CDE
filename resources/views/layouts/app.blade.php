<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DiabEduc')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        accent: {
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f5d0fe',
                            300: '#f0abfc',
                            400: '#e879f9',
                            500: '#d946ef',
                            600: '#c026d3',
                            700: '#a21caf',
                            800: '#86198f',
                            900: '#701a75',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
                        'glow': '0 0 20px rgba(59, 130, 246, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Base Styles */
        html, body { height: 100%; }
        
        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Glass Effect */
        .glass { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        
        /* Gradient Backgrounds */
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .gradient-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        .gradient-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .gradient-orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .gradient-red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        
        /* Card Hover Effects */
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15); }
        
        /* Button Effects */
        .btn-primary { 
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(59, 130, 246, 0.5);
        }
        
        /* Sidebar Link Active State */
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
            border-left: 3px solid #3b82f6;
            color: #1e40af;
        }
        
        /* Table Row Hover */
        .table-row-hover { transition: all 0.2s ease; }
        .table-row-hover:hover { background: linear-gradient(90deg, rgba(59, 130, 246, 0.05) 0%, transparent 100%); }
        
        /* Input Focus */
        .input-focus:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
    </style>
    @stack('head')
</head>
<body class="text-gray-800 bg-gradient-to-br from-slate-50 to-blue-50 antialiased">
    <!-- Content yields directly into body to allow View to control Flex layout -->
    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>