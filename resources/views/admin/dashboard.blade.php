@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- JUDUL --}}
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">
                    Aspirasi Mahasiswa Teknologi Informasi
                </h1>
                <p class="text-xl text-gray-500 dark:text-gray-400 font-medium">
                    Periode Tahun {{ $year }}
                </p>
            </div>

            {{-- TOMBOL EKSPOR EXCEL --}}
            <div class="mt-8 flex justify-center">
                <a href="{{ route('admin.export', ['year' => $year]) }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-full shadow-lg hover:shadow-green-500/30 transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Ekspor Data Tahun {{ $year }}
                </a>
            </div>
        </div>
    </div>

    {{-- 2. LOOPING KATEGORI --}}
    @php
        $categories = [
            ['title' => 'Kualitas Pelayanan Administrasi', 'key' => 'admin', 'chart_id' => 'pelayananAdminChart', 'colors' => ['#4f46e5', '#f59e0b', '#ef4444']],
            ['title' => 'Kualitas Kegiatan Belajar Mengajar (KBM)', 'key' => 'kbm', 'chart_id' => 'kbmChart', 'colors' => ['#10b981', '#f59e0b', '#ef4444']],
            ['title' => 'Pelayanan Laboratorium', 'key' => 'pelayanan_lab', 'chart_id' => 'pelayananLabChart', 'colors' => ['#3b82f6', '#f59e0b', '#ef4444']],
            ['title' => 'Fasilitas Laboratorium', 'key' => 'fasilitas_lab', 'chart_id' => 'fasilitasLabChart', 'colors' => ['#06b6d4', '#f59e0b', '#ef4444']],
            ['title' => 'Kinerja Himpunan (HMJ)', 'key' => 'kinerja_hmj', 'chart_id' => 'kinerjaHMJChart', 'colors' => ['#f59e0b', '#4f46e5', '#ef4444']],
            ['title' => 'Program Kerja HMJ', 'key' => 'proker_hmj', 'chart_id' => 'prokerHMJChart', 'colors' => ['#ef4444', '#4f46e5', '#f59e0b']],
        ];
    @endphp

    <div class="space-y-12 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 mb-20">
        @foreach($categories as $cat)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6 md:p-10">
                
                {{-- Judul Kategori --}}
                <h2 class="text-xl md:text-2xl font-bold text-center text-gray-800 dark:text-white mb-10 border-b border-gray-100 dark:border-gray-700 pb-4">
                    {{ $cat['title'] }}
                </h2>
                <div class="flex flex-col items-center">
                    
                    {{-- GRID DIAGRAM & ANALISIS --}}
                    <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center mb-12">
                        
                        {{-- Kolom 1: Diagram Pie --}}
                        <div class="flex flex-col items-center justify-center order-1 md:order-1">
                            <div class="relative w-64 h-64 md:w-72 md:h-72">
                                <canvas id="{{ $cat['chart_id'] }}"></canvas>
                            </div>
                        </div>

                        {{-- Kolom 2: Detail Analisis & Angka --}}
                        <div class="order-2 md:order-2 space-y-6">
                            @php
                                $total     = $summary['total_responden'] ?? 0;
                                $valBaik   = $summary['persentase_baik_' . $cat['key']] ?? 0;
                                $valCukup  = $summary['persentase_cukup_' . $cat['key']] ?? 0;
                                $valKurang = $summary['persentase_kurang_' . $cat['key']] ?? 0;

                                $countBaik   = round(($valBaik / 100) * $total);
                                $countCukup  = round(($valCukup / 100) * $total);
                                $countKurang = round(($valKurang / 100) * $total);
                            @endphp

                            {{-- List Detail Angka --}}
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                                <div class="space-y-6">
                                    
                                    {{-- Baris Baik --}}
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $cat['colors'][0] }}"></span>
                                                    <span class="font-bold text-gray-700 dark:text-gray-300">Baik</span>
                                                </div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    ({{ $countBaik }} dari {{ $total }} responden)
                                                </span>
                                            </div>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $valBaik }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                            <div class="h-2 rounded-full transition-all duration-500" style="width: {{ $valBaik }}%; background-color: {{ $cat['colors'][0] }}"></div>
                                        </div>
                                    </div>

                                    {{-- Baris Cukup --}}
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $cat['colors'][1] }}"></span>
                                                    <span class="font-bold text-gray-700 dark:text-gray-300">Cukup</span>
                                                </div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    ({{ $countCukup }} dari {{ $total }} responden)
                                                </span>
                                            </div>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $valCukup }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                            <div class="h-2 rounded-full transition-all duration-500" style="width: {{ $valCukup }}%; background-color: {{ $cat['colors'][1] }}"></div>
                                        </div>
                                    </div>

                                    {{-- Baris Kurang --}}
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $cat['colors'][2] }}"></span>
                                                    <span class="font-bold text-gray-700 dark:text-gray-300">Kurang</span>
                                                </div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    ({{ $countKurang }} dari {{ $total }} responden)
                                                </span>
                                            </div>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $valKurang }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                            <div class="h-2 rounded-full transition-all duration-500" style="width: {{ $valKurang }}%; background-color: {{ $cat['colors'][2] }}"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- BAGIAN BAWAH: LIST ASPIRASI & AI --}}
                    <div class="w-full max-w-4xl bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 border border-gray-100 dark:border-gray-600">
                        {{-- JUDUL ASPIRASI TANPA BULAN --}}
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            <span class="text-gray-500 dark:text-gray-300">Aspirasi & Masukan Responden (Tahun {{ $year }})</span>
                        </h3>
                        
                        {{-- LIST ASPIRASI MANUAL --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 overflow-y-auto max-h-80 pr-2 custom-scrollbar mb-8">
                            @forelse($grouped_aspirations[$cat['key']] ?? [] as $item)
                                {{-- AREA LOOP ASPIRASI (KOSONGKAN JIKA MEMANG TIDAK DITAMPILKAN MANUAL) --}}
                                
                            @empty
                                <div class="col-span-1 md:col-span-2 flex flex-col items-center justify-center text-center text-gray-400 py-4">
                                    <p class="text-xs">Data aspirasi mentah disembunyikan / kosong.</p>
                                </div>
                            @endforelse
                        </div>
                        
                        {{-- KONTAINER AI AUTO-SUMMARY --}}
                        <div class="flex flex-col items-center mb-4 w-full" 
                             id="ai-wrapper-{{ $cat['key'] }}" 
                             data-category="{{ $cat['key'] }}">

                            {{-- State: LOADING --}}
                            <div id="ai-loading-{{ $cat['key'] }}" class="w-full max-w-3xl p-5 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 animate-pulse">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-4 h-4 bg-indigo-300 rounded-full"></div>
                                    <div class="h-4 bg-indigo-200 rounded w-1/4"></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-3 bg-gray-200 rounded w-full"></div>
                                    <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                                    <div class="h-3 bg-gray-200 rounded w-4/6"></div>
                                </div>
                                <p class="text-xs text-center text-gray-500 mt-3">Sedang menganalisis aspirasi tahunan...</p>
                            </div>

                            {{-- State: RESULT --}}
                            <div id="ai-result-{{ $cat['key'] }}" class="hidden w-full max-w-3xl bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-lg p-5">
                                {{-- JUDUL AI TANPA BULAN --}}
                                <h4 class="text-sm font-bold text-indigo-800 dark:text-indigo-300 mb-2 flex items-center gap-2">
                                    <span>🤖</span> 
                                    Kesimpulan AI (Tahun {{ $year }})
                                </h4>
                                
                                <div id="ai-content-{{ $cat['key'] }}" class="ai-content text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                    {{-- Hasil Text AI akan masuk di sini --}}
                                </div>
                                
                                {{-- Opsi Refresh --}}
                                <div class="mt-3 text-right">
                                    <button onclick="fetchAISummary('{{ $cat['key'] }}', this)" class="text-xs text-indigo-600 hover:text-indigo-800 underline">
                                        Refresh Analisis
                                    </button>
                                </div>
                            </div>
                            
                            {{-- State: ERROR --}}
                            <div id="ai-error-{{ $cat['key'] }}" class="hidden w-full max-w-3xl p-4 bg-red-50 text-red-600 border border-red-200 rounded-lg text-sm text-center">
                                <span class="error-text">Gagal memuat analisis.</span> 
                                <button onclick="fetchAISummary('{{ $cat['key'] }}')" class="underline font-bold ml-2">Coba Lagi</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    // --- 1. FUNGSI FETCH AI (Updated: Force All Month) ---
    async function fetchAISummary(categoryKey, btnElement = null) {
        const loadingDiv = document.getElementById(`ai-loading-${categoryKey}`);
        const resultDiv = document.getElementById(`ai-result-${categoryKey}`);
        const errorDiv = document.getElementById(`ai-error-${categoryKey}`);
        
        if (!resultDiv) return;

        const contentDiv = resultDiv.querySelector('.ai-content');
        if (!contentDiv) return;

        let originalBtnText = '';

        // -- STEP A: RESET UI --
        if (loadingDiv) loadingDiv.classList.remove('hidden');
        resultDiv.classList.add('hidden');
        if (errorDiv) errorDiv.classList.add('hidden');

        if (btnElement) {
            originalBtnText = btnElement.innerHTML;
            btnElement.disabled = true;
            btnElement.innerHTML = '⏳ Memuat...';
        }

        // -- STEP B: FETCH DATA --
        try {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
            if (!token) throw new Error("CSRF Token tidak ditemukan.");

            const response = await fetch("{{ route('admin.ai.summarize') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    category: categoryKey,
                    year: "{{ $year }}",
                    month: 'all' // FORCE 'all' KARENA TIDAK ADA SLIDER
                })
            });

            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Server Error (HTML Response).");
            }

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || `Server Error: ${response.status}`);
            }

            // -- STEP C: SUKSES --
            contentDiv.innerHTML = data.summary;
            
            if (loadingDiv) loadingDiv.classList.add('hidden');
            resultDiv.classList.remove('hidden');

        } catch (error) {
            // -- STEP D: ERROR --
            console.error(`[AI Error - ${categoryKey}]:`, error);
            
            if (loadingDiv) loadingDiv.classList.add('hidden');
            if (errorDiv) {
                errorDiv.classList.remove('hidden');
                const errText = errorDiv.querySelector('.error-text');
                if(errText) errText.innerText = `Error: ${error.message}`;
            }

        } finally {
            // -- STEP E: RESET TOMBOL --
            if (btnElement) {
                btnElement.disabled = false;
                btnElement.innerHTML = originalBtnText;
            }
        }
    }

    // --- 2. STARTUP ---
    document.addEventListener('DOMContentLoaded', function() {
        const categories = @json(array_column($categories, 'key'));
        
        categories.forEach(key => {
            setTimeout(() => {
                fetchAISummary(key);
            }, 500); 
        });

        // --- 3. CHART SCRIPT ---
        const summaryData = @json($summary);

        const chartConfigs = [
            { id: 'pelayananAdminChart', key: 'admin', labels: ['Baik', 'Cukup', 'Kurang'], colors: ['#4f46e5', '#f59e0b', '#ef4444'] },
            { id: 'kbmChart', key: 'kbm', labels: ['Baik', 'Cukup', 'Kurang'], colors: ['#10b981', '#f59e0b', '#ef4444'] },
            { id: 'pelayananLabChart', key: 'pelayanan_lab', labels: ['Baik', 'Cukup', 'Kurang'], colors: ['#3b82f6', '#f59e0b', '#ef4444'] },
            { id: 'fasilitasLabChart', key: 'fasilitas_lab', labels: ['Baik', 'Cukup', 'Kurang'], colors: ['#06b6d4', '#f59e0b', '#ef4444'] },
            { id: 'kinerjaHMJChart', key: 'kinerja_hmj', labels: ['Baik', 'Cukup', 'Kurang'], colors: ['#f59e0b', '#4f46e5', '#ef4444'] },
            { id: 'prokerHMJChart', key: 'proker_hmj', labels: ['Baik', 'Cukup', 'Kurang'], colors: ['#ef4444', '#4f46e5', '#f59e0b'] }
        ];

        chartConfigs.forEach(config => {
            const ctx = document.getElementById(config.id);
            if (ctx) {
                const baik = summaryData['persentase_baik_' + config.key] || 0;
                const cukup = summaryData['persentase_cukup_' + config.key] || 0;
                const kurang = summaryData['persentase_kurang_' + config.key] || 0;

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: config.labels,
                        datasets: [{
                            data: [baik, cukup, kurang],
                            backgroundColor: config.colors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        });
    });
</script>
@endpush