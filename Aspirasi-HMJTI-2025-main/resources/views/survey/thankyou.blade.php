<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terima Kasih - Aspirasi TI 2025</title>
    
    {{-- Menggunakan Font yang sama dengan tema --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-['Plus_Jakarta_Sans'] text-gray-900 relative overflow-hidden">

    {{-- 1. Background Decor (Konsisten dengan halaman Survey) --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-500/10 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[10%] w-[40%] h-[40%] rounded-full bg-blue-500/10 blur-[100px]"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6">
        
        {{-- 2. Card Container: Glass Effect & Modern Shape --}}
        <div class="max-w-lg w-full text-center bg-white/70 backdrop-blur-2xl border border-white/60 shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] p-8 sm:p-12 relative overflow-hidden">
            
            {{-- Dekorasi Garis Atas --}}
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-500"></div>

            {{-- 3. Animated Icon Wrapper --}}
            <div class="mb-8 relative inline-flex items-center justify-center">
                {{-- Ping Animation --}}
                <span class="absolute flex h-full w-full">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-20"></span>
                </span>
                
                <div class="relative w-24 h-24 bg-gradient-to-br from-green-50 to-emerald-100 text-emerald-600 rounded-full flex items-center justify-center shadow-inner border border-green-100">
                    <svg class="w-10 h-10 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            {{-- 4. Typography --}}
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-4 tracking-tight text-gray-900">
                Aspirasi <span class="text-emerald-600">Terkirim!</span>
            </h1>
            
            <div class="text-gray-500 mb-10 leading-relaxed text-lg font-medium">
                @if(session('status'))
                    {{ session('status') }}
                @else
                    Terima kasih atas kontribusi Anda. <br class="hidden sm:block">Masukan jujur Anda adalah energi baru bagi kemajuan Jurusan Teknologi Informasi.
                @endif
            </div>

            {{-- 5. Button: Modern Dark Style --}}
            <a href="{{ url('/') }}" 
               class="group relative inline-flex items-center justify-center px-8 py-4 bg-gray-900 text-white font-bold rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/20 hover:-translate-y-1 active:scale-95 active:shadow-none w-full sm:w-auto">
                
                {{-- Gradient Hover Effect --}}
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <span class="relative flex items-center">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </span>
            </a>

            <div class="mt-8">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-widest">
                    {{ config('app.name', 'HMJ TI') }} &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>