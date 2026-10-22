@extends('layouts.admin')

@section('title', 'Analisis Partisipasi Kelas')

@section('content')
    {{-- 
        Wrapper utama menggunakan space-y-12 sesuai layout admin.
    --}}
    
    <div class="space-y-12">
            
        {{-- HEADER SECTION --}}
        <div class="text-center space-y-4 pt-4">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-white border border-indigo-100 shadow-sm">
                <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase">Monitoring Partisipasi</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight text-gray-900">
                Persentase <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">Responden Kelas</span>
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto">
                Memantau jumlah mahasiswa yang telah mengisi survei dibandingkan total mahasiswa per kelas.
            </p>
        </div>
        
        {{-- ========================================== --}}
        {{-- TAMBAHAN: SUMMARY TOTAL RESPONDEN ALL IN ONE --}}
        {{-- ========================================== --}}
        @if(count($groupedData) > 0)
            @php
                // Hitung Global Statistik di sini agar tidak mengubah controller
                $globalResponden = 0;
                $globalMahasiswa = 0;
                foreach($groupedData as $classes) {
                    $globalResponden += $classes->sum('total_responden');
                    $globalMahasiswa += $classes->sum('total_mahasiswa');
                }
                $globalPersen = $globalMahasiswa > 0 ? ($globalResponden / $globalMahasiswa) * 100 : 0;
            @endphp

            {{-- PARENT CARD WRAPPER --}}
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-indigo-100/50 relative overflow-hidden">
                {{-- Background decoration --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl -mr-16 -mt-16 opacity-50 pointer-events-none"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
                    
                    {{-- BAGIAN KIRI: TOTAL GLOBAL --}}
                    <div class="lg:col-span-4 flex flex-col justify-center text-center lg:text-left space-y-4 lg:border-r lg:border-gray-100 lg:pr-8">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Keseluruhan</span>
                            <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-2">{{ $globalResponden }}</h2>
                            <p class="text-sm text-gray-500 font-medium">dari {{ $globalMahasiswa }} Mahasiswa Terdata</p>
                        </div>

                        {{-- Global Progress Bar --}}
                        <div>
                            <div class="flex justify-between items-center text-xs mb-2">
                                <span class="font-bold text-indigo-600">{{ round($globalPersen) }}% Terisi</span>
                                <span class="text-gray-400">Target 100%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-500 h-3 rounded-full transition-all duration-1000" style="width: {{ $globalPersen }}%"></div>
                            </div>
                        </div>

                        <div class="bg-indigo-50 rounded-xl p-4 text-xs text-indigo-800 leading-relaxed text-left">
                            <span class="font-bold">Info:</span> Data di samping merupakan akumulasi dari seluruh Program Studi.
                        </div>
                    </div>

                    {{-- BAGIAN KANAN: GRID PER PRODI --}}
                    <div class="lg:col-span-8">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Rincian Per Program Studi</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($groupedData as $prodiName => $classes)
                                @php
                                    // Hitung Total Responden & Total Mahasiswa untuk Prodi ini
                                    $totalRespondenProdi = $classes->sum('total_responden');
                                    $totalMahasiswaProdi = $classes->sum('total_mahasiswa'); 
                                    
                                    // Hitung Persentase
                                    $persenProdi = $totalMahasiswaProdi > 0 ? ($totalRespondenProdi / $totalMahasiswaProdi) * 100 : 0;
                                    
                                    // Warna Icon & Progress Bar
                                    $isTRPL = str_contains(strtoupper($prodiName), 'TRPL') || str_contains(strtoupper($prodiName), 'REKAYASA');
                                    $cardBg = $isTRPL ? 'bg-orange-50 text-orange-600' : 'bg-indigo-50 text-indigo-600';
                                    $progressColor = $isTRPL ? 'bg-orange-500' : 'bg-indigo-500';
                                @endphp
                                
                                {{-- CARD KECIL PRODI --}}
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:bg-white hover:shadow-md transition-all duration-200 flex flex-col justify-between h-full">
                                    <div class="flex justify-between items-start mb-2 gap-2">
                                        <div class="flex-1 overflow-hidden">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 truncate" title="{{ $prodiName }}">
                                                {{ $prodiName }}
                                            </p>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-xl font-black text-gray-800">{{ $totalRespondenProdi }}</span>
                                                <span class="text-[10px] text-gray-500">/ {{ $totalMahasiswaProdi }}</span>
                                            </div>
                                        </div>
                                        <div class="h-8 w-8 rounded-lg {{ $cardBg }} flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        </div>
                                    </div>

                                    {{-- Mini Progress Bar --}}
                                    <div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                            <div class="{{ $progressColor }} h-1.5 rounded-full" style="width: {{ $persenProdi }}%"></div>
                                        </div>
                                        <div class="text-right mt-1">
                                            <span class="text-[10px] font-bold {{ $isTRPL ? 'text-orange-600' : 'text-indigo-600' }}">{{ round($persenProdi) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- ========================================== --}}

        <div class="border-b border-gray-200 my-8"></div>
        {{-- LOOPING PER PRODI (Bagian Bawah Tetap Sama) --}}
        @forelse($groupedData as $prodiName => $classes)
            <div class="space-y-6 animate-fade-in-up">
                
                {{-- Judul Prodi --}}
                <div class="flex items-center space-x-4">
                    <div class="h-8 w-1 bg-indigo-500 rounded-full"></div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $prodiName }}</h2>
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full border border-indigo-100">
                        {{ $classes->count() }} Kelas Terdata
                    </span>
                </div>

                {{-- Grid Kartu Kelas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($classes as $data)
                        @php
                            // ID Unik untuk Modal
                            $modalId = 'modal-' . Str::slug($data->kelas) . '-' . $loop->iteration;

                            // Logika Perhitungan Persentase Partisipasi
                            $totalMahasiswa = $data->total_mahasiswa ?? 0; 
                            $totalResponden = $data->total_responden;
                            $persentase = $totalMahasiswa > 0 ? ($totalResponden / $totalMahasiswa) * 100 : 0;
                            
                            // Warna Status Partisipasi
                            if($persentase >= 80) {
                                $colorText = 'text-emerald-600'; $bgBar = 'bg-emerald-500'; 
                                $statusLabel = 'Sangat Baik'; $statusBg = 'bg-emerald-50 text-emerald-700';
                            } elseif($persentase >= 50) {
                                $colorText = 'text-blue-600'; $bgBar = 'bg-blue-500';
                                $statusLabel = 'Cukup'; $statusBg = 'bg-blue-50 text-blue-700';
                            } else {
                                $colorText = 'text-red-600'; $bgBar = 'bg-red-500';
                                $statusLabel = 'Rendah'; $statusBg = 'bg-red-50 text-red-700';
                            }

                            // --- LOGIKA DATA MODAL (JAWABAN MAHASISWA) ---
                            // Ganti field ini dengan nama kolom asli di database Anda
                            $jmlBaik   = $data->baik ?? 0;   // Contoh: Jumlah mhs menjawab Baik
                            $jmlCukup  = $data->cukup ?? 0;  // Contoh: Jumlah mhs menjawab Cukup
                            $jmlKurang = $data->kurang ?? 0; // Contoh: Jumlah mhs menjawab Kurang
                            
                            $totalJawaban = $jmlBaik + $jmlCukup + $jmlKurang;
                            
                            // Hitung Persentase Jawaban (Hindari division by zero)
                            $pBaik   = $totalJawaban > 0 ? ($jmlBaik / $totalJawaban) * 100 : 0;
                            $pCukup  = $totalJawaban > 0 ? ($jmlCukup / $totalJawaban) * 100 : 0;
                            $pKurang = $totalJawaban > 0 ? ($jmlKurang / $totalJawaban) * 100 : 0;
                        @endphp

                        {{-- CARD KELAS --}}
                        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-xl hover:shadow-indigo-500/10 hover:border-indigo-200 transition-all duration-300 relative overflow-hidden flex flex-col justify-between h-full">
                            
                            {{-- Dekorasi Hover --}}
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gray-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>

                            <div class="relative z-10">
                                {{-- Header Kartu --}}
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Kelas</p>
                                        <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $data->kelas }}</h3>
                                    </div>
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $statusBg }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <div class="mb-6">
                                     <p class="text-xs text-gray-500">Target: {{ $totalMahasiswa }} Mahasiswa</p>
                                </div>

                                {{-- VISUALISASI PERSENTASE --}}
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                    <div class="flex justify-between items-end mb-2">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-semibold text-gray-500 mb-1">Capaian</span>
                                            <span class="text-4xl font-black {{ $colorText }}">
                                                {{ round($persentase) }}<span class="text-lg text-gray-400">%</span>
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="block text-xl font-bold text-gray-800">{{ $totalResponden }}</span>
                                            <span class="text-[10px] text-gray-500 uppercase font-bold">Responden</span>
                                        </div>
                                    </div>

                                    {{-- Progress Bar --}}
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div class="{{ $bgBar }} h-3 rounded-full transition-all duration-1000 ease-out relative" style="width: {{ $persentase }}%">
                                            <div class="absolute top-0 left-0 bottom-0 right-0 bg-gradient-to-r from-transparent via-white/30 to-transparent w-full -translate-x-full animate-[shimmer_2s_infinite]"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-2 flex justify-between text-[10px] text-gray-400 font-medium">
                                        <span>0%</span>
                                        <span>Target 100%</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer Action (BUTTON LIHAT DETAIL) --}}
                            <div class="mt-6 pt-4 border-t border-gray-50 flex justify-between items-center relative z-20">
                                <span class="text-xs text-gray-400">
                                    Kurang: <strong class="text-gray-700">{{ $totalMahasiswa - $totalResponden }}</strong> Mhs
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="border-b border-gray-200 my-8"></div>
        @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-gray-500 font-medium text-lg">Belum ada data kelas yang masuk.</p>
            </div>
        @endforelse

    </div>

    
@endsection