<x-app-layout>
    {{-- Container Utama --}}
    <div class="min-h-screen py-12 px-4 sm:px-6 relative z-10">
        <div class="max-w-4xl mx-auto space-y-10">
            
            {{-- 1. Header Section --}}
            <div class="text-center space-y-4">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/60 border border-indigo-100 backdrop-blur-md shadow-sm">
                    <span class="flex h-2 w-2 relative mr-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase">Suara Mahasiswa</span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black tracking-tight text-gray-900">
                    Aspirasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">2026</span>
                </h1>
                
                <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed font-medium">
                    Partisipasi Anda adalah kunci perubahan. Bantu kami meningkatkan kualitas layanan Jurusan Teknologi Informasi.
                </p>
            </div>

            {{-- 2. Main Card --}}
            <div class="bg-white/80 backdrop-blur-xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] rounded-[2rem] border border-white/50 relative overflow-hidden">
                
                {{-- Dekorasi Atas Card --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500"></div>

                <div class="p-8 sm:p-14">
                    
                    {{-- Alert Error --}}
                    @if (session('error'))
                    <div class="mb-10 flex items-start bg-red-50 text-red-700 p-5 rounded-2xl border border-red-100 shadow-sm animate-fade-in-down" role="alert">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <div>
                            <p class="font-bold text-lg">Terjadi Kesalahan</p>
                            <p class="text-sm opacity-90 mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('submit.survey') }}" class="space-y-10">
                        @csrf 
                        <input type="hidden" name="device_id" id="device_id">
                        
                        {{-- === IDENTITAS MAHASISWA (DINAMIS DARI DATABASE) === --}}
                        <div class="group p-6 sm:p-8 rounded-3xl bg-indigo-50/40 border border-indigo-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300">

                            <h2 class="text-lg font-bold tracking-tight text-gray-900 mb-6">
                                Informasi Mahasiswa
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                
                                {{-- PRODI (Select Pertama) --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                        Program Studi
                                    </label>
                                    <select name="prodi" id="prodi_select" required
                                        class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm">
                                        <option value="">Pilih Prodi</option>
                                        @foreach($prodiList as $prodi)
                                            <option value="{{ $prodi }}" {{ old('prodi') == $prodi ? 'selected' : '' }}>
                                                {{ $prodi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- KELAS (Select Kedua - Dinamis) --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                        Kelas
                                    </label>
                                    <select name="kelas" id="kelas_select" required disabled
                                        class="w-full rounded-xl border-gray-200 bg-gray-100 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm disabled:cursor-not-allowed disabled:opacity-60">
                                        <option value="">Pilih Prodi Terlebih Dahulu</option>
                                        
                                        {{-- Loop semua kelas (akan difilter oleh JS) --}}
                                        @foreach($allKelas as $item)
                                            <option value="{{ $item->kelas }}" 
                                                    data-prodi="{{ $item->prodi }}"
                                                    class="kelas-option hidden"
                                                    {{ old('kelas') == $item->kelas ? 'selected' : '' }}>
                                                {{ $item->kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>

                        {{-- === QUESTION SECTIONS (SEMUA 6 PERTANYAAN) === --}}
                        <div class="grid gap-8">
                            
                            {{-- 1. Administrasi --}}
                            <div class="group p-6 sm:p-8 rounded-3xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300 relative">
                                <div class="relative z-10">
                                    <x-survey-question 
                                        name="pelayanan_administrasi" 
                                        question="1. Bagaimana pendapat Anda terkait dengan pelayanan Administrasi di Jurusan TI?" 
                                    />
                                    <div class="mt-6 pt-6 border-t border-gray-200/60 group-hover:border-indigo-50 transition-colors">
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-hover:text-indigo-500 transition-colors">Saran & Masukan</label>
                                        <textarea name="admin_feedback" rows="2" placeholder="Tulis detail pengalaman Anda..."
                                            class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-300 text-sm py-3 px-4 shadow-sm">{{ old('admin_feedback') }}</textarea>
                                    </div>
                                </div>
                            </div>
                    
                            {{-- 2. KBM --}}
                            <div class="group p-6 sm:p-8 rounded-3xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300">
                                <x-survey-question 
                                    name="kegiatan_belajar_mengajar" 
                                    question="2. Bagaimana kualitas kegiatan belajar mengajar yang dilaksanakan saat ini?" 
                                />
                                <div class="mt-6 pt-6 border-t border-gray-200/60 group-hover:border-indigo-50 transition-colors">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-hover:text-indigo-500 transition-colors">Saran & Masukan</label>
                                    <textarea name="kbm_feedback" rows="2" placeholder="Tulis detail pengalaman Anda..."
                                        class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-300 text-sm py-3 px-4 shadow-sm">{{ old('kbm_feedback') }}</textarea>
                                </div>
                            </div>
                    
                            {{-- 3. Pelayanan Lab --}}
                            <div class="group p-6 sm:p-8 rounded-3xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300">
                                <x-survey-question 
                                    name="pelayanan_lab" 
                                    question="3. Bagaimana pendapat Anda terkait pelayanan Teknisi Lab di Jurusan TI?" 
                                />
                                <div class="mt-6 pt-6 border-t border-gray-200/60 group-hover:border-indigo-50 transition-colors">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-hover:text-indigo-500 transition-colors">Saran & Masukan</label>
                                    <textarea name="pelayanan_lab_feedback" rows="2" placeholder="Tulis detail pengalaman Anda..."
                                        class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-300 text-sm py-3 px-4 shadow-sm">{{ old('pelayanan_lab_feedback') }}</textarea>
                                </div>
                            </div>
                    
                            {{-- 4. Fasilitas Lab --}}
                            <div class="group p-6 sm:p-8 rounded-3xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300">
                                <x-survey-question 
                                    name="fasilitas_lab" 
                                    question="4. Bagaimana kondisi fasilitas dan perangkat (PC/Alat) di Lab saat ini?" 
                                />
                                <div class="mt-6 pt-6 border-t border-gray-200/60 group-hover:border-indigo-50 transition-colors">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-hover:text-indigo-500 transition-colors">Saran & Masukan</label>
                                    <textarea name="fasilitas_lab_feedback" rows="2" placeholder="Tulis detail pengalaman Anda..."
                                        class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-300 text-sm py-3 px-4 shadow-sm">{{ old('fasilitas_lab_feedback') }}</textarea>
                                </div>
                            </div>
                    
                            {{-- 5. Kinerja HMJ --}}
                            <div class="group p-6 sm:p-8 rounded-3xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300">
                                <x-survey-question name="kinerja_hmj" question="5. Bagaimana kinerja HMJ TI selama tahun 2026 ini?" />
                                <div class="mt-6 pt-6 border-t border-gray-200/60 group-hover:border-indigo-50 transition-colors">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-hover:text-indigo-500 transition-colors">Saran & Masukan</label>
                                    <textarea name="kinerja_hmj_feedback" rows="2" placeholder="Tulis detail pengalaman Anda..."
                                        class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-300 text-sm py-3 px-4 shadow-sm">{{ old('kinerja_hmj_feedback') }}</textarea>
                                </div>
                            </div>
                    
                            {{-- 6. Proker HMJ --}}
                            <div class="group p-6 sm:p-8 rounded-3xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300">
                                <x-survey-question name="proker_hmj" question="6. Bagaimana relevansi Program Kerja HMJ dengan kebutuhan Anda?" />
                                <div class="mt-6 pt-6 border-t border-gray-200/60 group-hover:border-indigo-50 transition-colors">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-hover:text-indigo-500 transition-colors">Saran & Masukan</label>
                                    <textarea name="proker_hmj_feedback" rows="2" placeholder="Tulis detail pengalaman Anda..."
                                        class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-300 text-sm py-3 px-4 shadow-sm">{{ old('proker_hmj_feedback') }}</textarea>
                                </div>
                            </div>

                        </div>

                        {{-- Tombol Submit --}}
                        <div class="pt-8 flex flex-col items-center justify-center space-y-4">
                            <button type="submit" 
                                class="group relative w-full sm:w-auto inline-flex items-center justify-center px-12 py-4 bg-gray-900 border border-transparent rounded-2xl font-bold text-white tracking-widest hover:scale-[1.02] active:scale-95 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all duration-200 shadow-xl overflow-hidden">
                                
                                {{-- Gradient Overlay on Hover --}}
                                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <span class="relative flex items-center">
                                    Kirim Aspirasi
                                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </button>
                            <p class="text-xs text-gray-400 font-medium">Data Anda akan disimpan secara anonim & aman.</p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        // === 1. LOGIKA DEVICE ID (TETAP) ===
        let deviceToken = localStorage.getItem('survey_device_token');
        if (!deviceToken) {
            deviceToken = 'DEV-' + Math.random().toString(36).substring(2, 15) + '-' + Date.now();
            localStorage.setItem('survey_device_token', deviceToken);
        }
        const deviceInput = document.getElementById('device_id');
        if (deviceInput) { deviceInput.value = deviceToken; }

        // === 2. LOGIKA DEPENDENT DROPDOWN (BARU) ===
        const prodiSelect = document.getElementById('prodi_select');
        const kelasSelect = document.getElementById('kelas_select');
        const kelasOptions = document.querySelectorAll('.kelas-option');

        function filterKelas() {
            const selectedProdi = prodiSelect.value;
            
            // Reset Kelas Select
            kelasSelect.value = ""; 
            
            // Logic Enable/Disable
            if(selectedProdi) {
                kelasSelect.disabled = false;
                kelasSelect.classList.remove('bg-gray-100');
                kelasSelect.classList.add('bg-white');
                kelasSelect.options[0].text = "Pilih Kelas";
            } else {
                kelasSelect.disabled = true;
                kelasSelect.classList.add('bg-gray-100');
                kelasSelect.classList.remove('bg-white');
                kelasSelect.options[0].text = "Pilih Prodi Terlebih Dahulu";
            }

            // Logic Show/Hide Options
            kelasOptions.forEach(option => {
                if (option.getAttribute('data-prodi') === selectedProdi) {
                    option.hidden = false;
                    option.style.display = 'block'; // Fallback for older browsers
                } else {
                    option.hidden = true;
                    option.style.display = 'none';
                }
            });
        }

        // Event Listener saat Prodi berubah
        prodiSelect.addEventListener('change', filterKelas);

        // Cek saat halaman dimuat (untuk handle old input validation error)
        if(prodiSelect.value) {
            const oldKelas = "{{ old('kelas') }}"; // Ambil old value kelas dari PHP
            
            // Jalankan filter
            filterKelas();
            
            // Jika ada old kelas, set nilainya kembali
            if(oldKelas) {
                kelasSelect.value = oldKelas;
            }
        }
    });
</script>
</x-app-layout>