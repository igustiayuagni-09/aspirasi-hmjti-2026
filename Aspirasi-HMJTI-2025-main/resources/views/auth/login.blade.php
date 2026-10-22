<x-app-layout>
    {{-- 1. Style Animasi (Tetap sama, logika sudah bagus) --}}
    <style>
        @keyframes soft-drift {
            0% { transform: translate(-50%, -50%) rotate(-20deg); opacity: 0; }
            15% { opacity: var(--target-opacity, 0.2); }
            85% { opacity: var(--target-opacity, 0.2); }
            100% { transform: translate(120vw, 120vh) rotate(180deg); opacity: 0; }
        }
        .animate-drift-slow { animation: soft-drift 35s linear infinite; }
        .animate-drift-medium { animation: soft-drift 25s linear infinite; }
        .animate-drift-fast { animation: soft-drift 18s linear infinite; }
    </style>

    {{-- 
        PERBAIKAN UTAMA: 
        1. Hapus 'bg-[#F8FAFC]' dari container utama (dipindah ke layer background).
        2. Hapus 'overflow-hidden' dari sini agar tidak memotong bayangan card.
        3. Tambahkan '-mt-8' (margin top negatif) untuk melawan padding default layout jika perlu, 
           tapi solusi 'fixed' di bawah sudah menangani background.
    --}}
    <div class="min-h-screen w-full flex flex-col justify-center relative">
        
        {{-- 
            2. Layer Animasi Background 
            PERBAIKAN: Mengubah 'absolute' menjadi 'fixed'.
            Ini memaksa background keluar dari batasan Layout padding 
            dan memenuhi seluruh layar monitor (viewport).
            z-0 agar berada di paling belakang.
        --}}
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#F8FAFC] dark:bg-[#F8FAFC]" aria-hidden="true">
            {{-- Logo 1 --}}
            <img src="{{ asset('images/logo-hmjti.png') }}" 
                 class="absolute top-[-10%] left-[-10%] w-[900px] opacity-0 blur-md animate-drift-slow" 
                 style="animation-delay: 0s; --target-opacity: 0.3;">

            {{-- Logo 2 --}}
            <img src="{{ asset('images/logo-hmjti.png') }}" 
                 class="absolute top-[10%] left-[20%] w-[600px] opacity-0 blur-sm animate-drift-medium" 
                 style="animation-delay: -10s; --target-opacity: 0.4;">

            {{-- Logo 3 --}}
            <img src="{{ asset('images/logo-hmjti.png') }}" 
                 class="absolute top-[-5%] left-[60%] w-[400px] opacity-0 blur-md animate-drift-fast" 
                 style="animation-delay: -5s; --target-opacity: 0.35;">

            {{-- Logo 4 --}}
            <img src="{{ asset('images/logo-hmjti.png') }}" 
                 class="absolute top-[40%] left-[-20%] w-[1100px] opacity-0 blur-lg animate-drift-slow" 
                 style="animation-delay: -20s; --target-opacity: 0.4;">
            
            {{-- Logo 5 --}}
            <img src="{{ asset('images/logo-hmjti.png') }}" 
                 class="absolute top-[50%] left-[40%] w-[500px] opacity-0 blur-md animate-drift-fast" 
                 style="animation-delay: -15s; --target-opacity: 0.5;">

            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-br from-white/30 via-slate-50/50 to-blue-50/30"></div>
        </div>

        {{-- 
            3. Card Container 
            PERBAIKAN: Tambahkan 'relative z-10' agar form muncul DI ATAS background fixed tadi.
        --}}
        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            {{-- Logo / Back to Home --}}
            <div class="flex justify-center mb-6">
                <a href="/" class="flex items-center group">
                    <div class="">
                        <x-logo-hmjti class="" />
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-slate-900">Aspirasi <span class="text-indigo-600">TI</span></span>
                </a>
            </div>

            <div class="bg-white dark:bg-white py-10 px-8 shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] border border-gray-100">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-900">Log in Admin</h2>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-500 font-medium">
                        Silakan masuk untuk mengelola data aspirasi mahasiswa.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    {{-- Input Fields tetap sama --}}
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-700 ml-1 mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            class="w-full px-5 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 text-slate-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none placeholder:text-gray-400"
                            placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-700 ml-1 mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full px-5 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 text-slate-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none placeholder:text-gray-400"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded-lg border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0 w-5 h-5" name="remember">
                            <span class="ms-3 text-sm font-semibold text-slate-600 dark:text-slate-600">{{ __('Ingat saya') }}</span>
                        </label>
                    </div>

                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-indigo-200 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all active:scale-[0.98]">
                            {{ __('Masuk Ke Dashboard') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>