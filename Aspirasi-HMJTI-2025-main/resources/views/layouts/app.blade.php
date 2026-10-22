<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HMJ Teknologi Informasi') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    {{-- 
        PERBAIKAN UTAMA: Tambahkan 'overflow-x-hidden' di sini. 
        Karena animasi drift bergerak ke 'translate(120vw)', tanpa ini 
        halaman akan bergoyang atau muncul scrollbar bawah.
    --}}
    <body class="font-sans antialiased text-gray-900 overflow-x-hidden">
        
        {{-- Background Decor tetap --}}
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-500/5 blur-[120px]"></div>
            <div class="absolute top-[40%] -right-[5%] w-[30%] h-[30%] rounded-full bg-blue-500/5 blur-[100px]"></div>
        </div>

        <div class="min-h-screen bg-[#F8FAFC]">
            
            {{-- @include('layouts.navigation') --}}

            @isset($header)
                <header class="relative pt-6 pb-2">
                    {{-- Code Header tetap sama --}}
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                                    {{ $header }}
                                </h1>
                                <p class="text-sm font-medium text-indigo-600">
                                    Pusat Kendali Sistem
                                </p>
                            </div>
                            <div id="header-actions"></div>
                        </div>
                    </div>
                </header>
            @endisset

            {{-- 
               Area ini tetap ada paddingnya. 
               Tapi karena Login Background sudah kita set 'fixed', 
               dia akan mengabaikan padding ini dan tampil full screen.
            --}}
            <main class="relative py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-6 text-center text-sm text-gray-400 font-medium">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </footer>
        </div>

        @stack('scripts')
    </body>
</html>