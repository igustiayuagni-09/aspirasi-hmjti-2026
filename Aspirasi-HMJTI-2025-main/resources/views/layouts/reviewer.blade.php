<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Penting untuk keamanan --}}

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Chart.js lebih baik ditaruh di sini agar siap digunakan oleh view --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <div class="min-h-screen flex flex-col">
        {{-- Navbar --}}
        <header class="bg-white shadow-sm border-b px-8 py-4 flex justify-between items-center sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <h2 class="text-xl font-bold text-indigo-600">Reviewer Panel</h2>
                <nav class="hidden md:flex gap-4 ml-6 text-sm font-medium text-gray-600">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                </nav>
            </div>

            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 hidden sm:inline">{{ now()->translatedFormat('d F Y') }}</span>
                
                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700 transition">
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-grow p-4 md:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        {{-- Footer Sederhana --}}
        <footer class="bg-white border-t px-8 py-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>