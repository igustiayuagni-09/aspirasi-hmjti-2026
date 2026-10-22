@extends('layouts.reviewer')

@section('title', 'Dashboard Reviewer')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- HEADER BARU & SLIDER BULAN --}}
            <div class="mb-12 text-center">
                @php
                    // Ambil tahun dan bulan dari request, default ke waktu sekarang
                    $currentYear = request('year', date('Y'));
                    $currentMonth = request('month', date('n'));
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                @endphp

                {{-- JUDUL --}}
                <h1 class="text-3xl md:text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-6">
                    Aspirasi Mahasiswa Teknologi Informasi Tahun {{ $currentYear }}
                </h1>

                {{-- SLIDER BULAN (CAROUSEL MODE) --}}
                <div class="relative max-w-md mx-auto">
                    
                    @php
                        // Logika Navigasi: Tentukan bulan saat ini (angka) untuk kalkulasi prev/next
                        // Jika sedang 'all', anggap start dari bulan ini atau Januari (1)
                        $numericMonth = is_numeric($currentMonth) ? (int)$currentMonth : (int)date('n');
                        
                        // Hitung Prev & Next dengan rotasi (1 -> 12, 12 -> 1)
                        $prevMonth = $numericMonth == 1 ? 12 : $numericMonth - 1;
                        $nextMonth = $numericMonth == 12 ? 1 : $numericMonth + 1;
                    @endphp

                    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-2 rounded-full shadow-md border border-gray-200 dark:border-gray-700">
                        
                        {{-- Tombol Previous (<) --}}
                        <a href="{{ route(Route::currentRouteName(), array_merge(request()->all(), ['month' => $prevMonth])) }}" 
                           class="p-3 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700 text-indigo-600 dark:text-indigo-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>

                        {{-- Teks Bulan Tengah --}}
                        <div class="flex-1 text-center px-4">
                            <span class="text-lg md:text-xl font-bold text-gray-800 dark:text-white block">
                                {{-- Jika request 'all', tampilkan teks 'Semua Bulan', jika tidak tampilkan nama bulan dari array --}}
                                {{ $currentMonth == 'all' ? 'Semua Bulan' : ($months[$numericMonth] ?? 'Bulan Tidak Valid') }}
                            </span>
                            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">
                                Periode Data
                            </span>
                        </div>

                        {{-- Tombol Next (>) --}}
                        <a href="{{ route(Route::currentRouteName(), array_merge(request()->all(), ['month' => $nextMonth])) }}" 
                           class="p-3 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700 text-indigo-600 dark:text-indigo-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    {{-- Opsi Kembali ke "Semua Bulan" (Hanya muncul jika sedang memilih bulan spesifik) --}}
                    @if($currentMonth != 'all')
                    <div class="text-center mt-4">
                        <a href="{{ route(Route::currentRouteName(), array_merge(request()->all(), ['month' => 'all'])) }}" 
                           class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 underline decoration-dotted underline-offset-4">
                            Tampilkan Data Setahun Penuh
                        </a>
                    </div>
                    @endif

                    {{-- TOMBOL EKSPOR EXCEL (BARU) --}}
                    <div class="mt-6 flex justify-center">
                        {{-- Menggunakan request()->all() agar filter tahun/bulan saat ini terbawa --}}
                        <a href="{{ route('admin.export', request()->all()) }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-full shadow-md transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Ekspor ke Excel
                        </a>
                    </div>
                    
                </div>
            </div>

            {{-- 2. LOOPING KATEGORI: DIAGRAM + ANALISIS + ASPIRASI (TETAP DIPAKAI) --}}
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

            <div class="space-y-12">
                @foreach($categories as $cat)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-6 md:p-10">
                        
                        {{-- Judul Kategori --}}
                        <h2 class="text-xl md:text-2xl font-bold text-center text-gray-800 dark:text-white mb-10 border-b border-gray-100 dark:border-gray-700 pb-4">
                            {{ $cat['title'] }}
                        </h2>

                        <div class="flex flex-col items-center">
                            
                            {{-- BAGIAN TENGAH: GRID DIAGRAM (KIRI) & ANALISIS ANGKA (KANAN) --}}
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
                                        // Ambil Data Dasar
                                        $total     = $summary['total_responden'] ?? 0;
                                        $valBaik   = $summary['persentase_baik_' . $cat['key']] ?? 0;
                                        $valCukup  = $summary['persentase_cukup_' . $cat['key']] ?? 0;
                                        $valKurang = $summary['persentase_kurang_' . $cat['key']] ?? 0;

                                        // Hitung jumlah orang berdasarkan persentase (pembulatan)
                                        $countBaik   = round(($valBaik / 100) * $total);
                                        $countCukup  = round(($valCukup / 100) * $total);
                                        $countKurang = round(($valKurang / 100) * $total);
                                    @endphp

                                    {{-- List Detail Angka Dengan Keterangan Sederhana --}}
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

                            {{-- BAGIAN BAWAH: LIST ASPIRASI (DIMODIFIKASI UNTUK HIDE TOTAL) --}}
                            <div class="w-full max-w-4xl bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 border border-gray-100 dark:border-gray-600">
                                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                    <span class="text-gray-500 dark:text-gray-300">Aspirasi & Masukan Responden ({{ $months[$currentMonth] ?? 'Semua Bulan' }} {{ $currentYear }})</span>
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 overflow-y-auto max-h-80 pr-2 custom-scrollbar">
                                    @forelse($grouped_aspirations[$cat['key']] ?? [] as $item)
                                        @php
                                            $feedbackField = $cat['key'] . '_feedback';
                                            $visibilityField = 'is_visible_' . $feedbackField;
                                        @endphp

                                        @if($item->$visibilityField)
                                            {{-- PERBAIKAN UTAMA: Tambahkan 'min-w-0' di sini agar Grid item tidak melebar --}}
                                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm text-sm text-gray-700 dark:text-gray-300 border-l-4 flex flex-col min-w-0" style="border-color: {{ $cat['colors'][0] }}">
                                                
                                                {{-- PERBAIKAN TEKS: Gunakan 'break-words' (normal) atau 'break-all' (paksa potong kata panjang tanpa spasi) --}}
                                                <p class="italic break-words whitespace-normal w-full mb-2" style="word-break: break-word;">
                                                    "{{ $item->$feedbackField ?? 'Tidak ada masukan teks.' }}"
                                                </p>

                                                <div class="mt-auto text-xs text-gray-400 text-right">
                                                    {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') : 'Baru saja' }}
                                                </div>
                                            </div>
                                        @endif
                                        
                                    @empty
                                        <div class="col-span-1 md:col-span-2 flex flex-col items-center justify-center text-center text-gray-400 py-10">
                                            <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            <p class="text-sm">Belum ada masukan teks untuk kategori ini pada periode ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- FOOTER ACTION --}}
            <div class="mt-12 text-center">
                 <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                    Lihat Laporan Lengkap
                </a>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dataSummary = @json($summary);
        const labels = ['Baik', 'Cukup', 'Kurang'];
        
        function initChart(elementId, key, bgColors) {
            const ctx = document.getElementById(elementId);
            if (!ctx) return;

            new Chart(ctx, {
                type: 'doughnut', 
                data: {
                    labels: labels,
                    datasets: [{
                        data: [
                            dataSummary[`persentase_baik_${key}`] || 0,
                            dataSummary[`persentase_cukup_${key}`] || 0,
                            dataSummary[`persentase_kurang_${key}`] || 0
                        ],
                        backgroundColor: bgColors,
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: { 
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false }, 
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    }
                }
            });
        }

        initChart('pelayananAdminChart', 'admin', ['#4f46e5', '#f59e0b', '#ef4444']);
        initChart('kbmChart', 'kbm', ['#10b981', '#f59e0b', '#ef4444']);
        initChart('pelayananLabChart', 'pelayanan_lab', ['#3b82f6', '#f59e0b', '#ef4444']);
        initChart('fasilitasLabChart', 'fasilitas_lab', ['#06b6d4', '#f59e0b', '#ef4444']);
        initChart('kinerjaHMJChart', 'kinerja_hmj', ['#f59e0b', '#4f46e5', '#ef4444']);
        initChart('prokerHMJChart', 'proker_hmj', ['#ef4444', '#4f46e5', '#f59e0b']);
    });
</script>
<style>
    /* Utility class untuk menyembunyikan scrollbar namun tetap bisa scroll */
    .custom-scrollbar::-webkit-scrollbar {
        height: 4px;
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(156, 163, 175, 0.5);
        border-radius: 20px;
    }
</style>
@endpush