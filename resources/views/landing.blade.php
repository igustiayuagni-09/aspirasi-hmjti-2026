<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aspirasi TI 2025</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        
        /* Fix untuk Gradient Text */
        .gradient-text {
            background: linear-gradient(to right, #4f46e5, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent; 
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        /* --- TAMBAHAN ANIMASI LOGO --- */
        @keyframes diagonal-one-way {
            0% { 
                transform: translate(-25%, -75%) rotate(-18deg); 
                opacity: 0; 
            }
            20% { 
                opacity: var(--target-opacity, 0.2); 
            }
            80% { 
                opacity: var(--target-opacity, 0.2); 
            }
            100% { 
                transform: translate(120vw, 120vh) rotate(180deg); 
                opacity: 0; 
            }
        }

        .animate-huge-slow { animation: diagonal-one-way 30s linear infinite; }
        .animate-huge-medium { animation: diagonal-one-way 20s linear infinite; }
        .animate-huge-fast { animation: diagonal-one-way 15s linear infinite; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 dark:bg-slate-50 dark:text-slate-900 antialiased selection:bg-indigo-500 selection:text-white">

    <div class="relative overflow-hidden min-h-screen flex items-center justify-center">
        
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <img src="{{ asset('images/logo-hmjti.png') }}" 
                class="absolute top-[-10%] left-[-10%] w-[1000px] opacity-20 blur-md animate-huge-slow" 
                style="animation-delay: -5s; --target-opacity: 0.4;">

            <img src="{{ asset('images/logo-hmjti.png') }}" 
                class="absolute top-[20%] left-[15%] w-[700px] opacity-25 blur-sm animate-huge-medium" 
                style="animation-delay: -12s; --target-opacity: 0.5;">

            <img src="{{ asset('images/logo-hmjti.png') }}" 
                class="absolute top-[-5%] left-[60%] w-[500px] opacity-20 blur-md animate-huge-fast" 
                style="animation-delay: -2s; --target-opacity: 0.45;">

            <img src="{{ asset('images/logo-hmjti.png') }}" 
                class="absolute top-[50%] left-[-20%] w-[1200px] opacity-15 blur-lg animate-huge-slow" 
                style="animation-delay: -16s; --target-opacity: 0.5;">
            
            <img src="{{ asset('images/logo-hmjti.png') }}" 
                class="absolute top-[60%] left-[40%] w-[600px] opacity-20 blur-md animate-huge-fast" 
                style="animation-delay: -8s; --target-opacity: 0.6;">

            <div class="absolute inset-0 bg-gradient-to-br from-white/20 via-slate-50/40 to-blue-50/20"></div>
        </div>

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-indigo-200/80 blur-[100px] mix-blend-multiply animate-blob"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-blue-200/80 blur-[100px] mix-blend-multiply animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-24 text-center relative z-10">
            {{-- Badge --}}
            <div data-aos="fade-down" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 border border-indigo-100 text-indigo-700 text-sm font-bold mb-8 shadow-sm backdrop-blur-sm">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-600"></span>
                </span>
                Aspirasi Mahasiswa Teknologi Informasi 2025
            </div>

            {{-- Headline --}}
            <h1 data-aos="fade-up" data-aos-delay="200" class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-slate-900 mb-6 leading-[1.15]">
                Sampaikan Aspirasi Anda, <br class="hidden md:block"/>
                <span class="gradient-text pb-2">Wujudkan Perubahan.</span>
            </h1>

            {{-- Subheadline --}}
            <p data-aos="fade-up" data-aos-delay="400" class="text-lg md:text-xl text-slate-600 dark:text-slate-600 max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
                Platform resmi survei kepuasan Jurusan Teknologi Informasi. 
                Suara Anda adalah kunci peningkatan kualitas akademik.
            </p>

            {{-- CTA Button --}}
            <div data-aos="zoom-in" data-aos-delay="600" class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('survey.index') }}" 
                   class="group w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-500/20 transition-all hover:-translate-y-1 hover:shadow-2xl active:scale-95 flex items-center justify-center gap-3">
                    Mulai Isi Survei
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-cubic',
            offset: 50
        });
    </script>
</body>
</html>