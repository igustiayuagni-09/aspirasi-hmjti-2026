<x-app-layout>
    <div class="min-h-screen py-12 px-4 sm:px-6 relative z-10">
        <div class="max-w-4xl mx-auto space-y-10">
            
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

            <div class="bg-white/80 backdrop-blur-xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] rounded-[2rem] border border-white/50 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500"></div>
                <div class="p-8 sm:p-14">
                    
                    @if (session('error'))
                    <div class="mb-10 flex items-start bg-red-50 text-red-700 p-5 rounded-2xl border border-red-100 shadow-sm" role="alert">
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
                        
                        <div class="group p-6 sm:p-8 rounded-3xl bg-indigo-50/40 border border-indigo-100 hover:bg-white hover:shadow-xl transition-all duration-300">
                            <h2 class="text-lg font-bold tracking-tight text-gray-900 mb-6">Informasi Mahasiswa</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Program Studi</label>
                                    <select name="prodi" id="prodi_select" required class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm">
                                        <option value="">Pilih Prodi</option>
                                        @foreach($prodiList as $prodi)
                                            <option value="{{ $prodi }}" {{ old('prodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Kelas</label>
                                    <select name="kelas" id="kelas_select" required disabled class="w-full rounded-xl border-gray-200 bg-gray-100 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm disabled:opacity-60">
                                        <option value="">Pilih Prodi Terlebih Dahulu</option>
                                        @foreach($allKelas as $item)
                                            <option value="{{ $item->kelas }}" data-prodi="{{ $item->prodi }}" class="kelas-option hidden" {{ old('kelas') == $item->kelas ? 'selected' : '' }}>{{ $item->kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-8">
                            @php
                                $questions = [
                                    ['name' => 'pelayanan_administrasi', 'q' => '1. Bagaimana pendapat Anda terkait dengan pelayanan Administrasi di Jurusan TI?'],
                                    ['name' => 'informasi_administrasi', 'q' => '2. Bagaimana Prosedur penyampaian informasi terkait administrasi?'],
                                    ['name' => 'pelaksanaan_kbm', 'q' => '3. Bagaimana kualitas kegiatan belajar mengajar yang dilaksanakan saat ini?'],
                                    ['name' => 'kenyamanan_kelas', 'q' => '4. Apakah materi pembelajaran mudah dipahami dan kelas nyaman?'],
                                    ['name' => 'fasilitas_lab', 'q' => '5. Bagaimana pendapat Anda terkait pelayanan Teknisi Lab di Jurusan TI?'],
                                    ['name' => 'ruang_lab', 'q' => '6. Bagaimana kondisi fasilitas dan perangkat (PC/Alat) di Lab saat ini?'],
                                    ['name' => 'fasilitas_kampus', 'q' => '7. Bagaimana kondisi Ruang laboratorium yang tersedia saat ini?'],
                                    ['name' => 'fasilitas_penunjang', 'q' =>'8. Bagaimana efektivitas HMJ sebagai jembatan komunikasi antara mahasiswa dengan pihak jurusan?'],
                                    ['name' => 'kinerja_hmj', 'q' => '9. Bagaimana kinerja HMJ TI selama tahun 2026 ini?'],
                                    ['name' => 'transparansi_hmj', 'q' => '10. Bagaimana transparansi informasi dan dukungan HMJ TI terhadap prestasi mahasiswa?'],
                                    ['name' => 'proker_hmj', 'q' => '11. Apakah informasi terkait pelaksanaan Program Kerja tersampaikan dengan jelas dan tepat waktu?'],
                                ];
                            @endphp

                            @foreach($questions as $item)
                            <div class="group p-6 sm:p-8 rounded-3xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:border-indigo-100 transition-all duration-300">
                                <x-survey-question :name="$item['name']" :question="$item['q']" />
                                <div class="mt-6 pt-6 border-t border-gray-200/60 group-hover:border-indigo-50 transition-colors">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-hover:text-indigo-500 transition-colors">Saran & Masukan untuk poin ini</label>
                                    <textarea name="{{ $item['name'] }}_feedback" rows="2" placeholder="Tulis saran Anda di sini..."
                                        class="w-full rounded-xl border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-400 text-sm py-3 px-4 shadow-sm">{{ old($item['name'].'_feedback') }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="pt-8 flex flex-col items-center justify-center space-y-4">
                            <button type="submit" class="group relative w-full sm:w-auto inline-flex items-center justify-center px-12 py-4 bg-gray-900 border border-transparent rounded-2xl font-bold text-white tracking-widest hover:scale-[1.02] active:scale-95 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all duration-200 shadow-xl overflow-hidden">
                                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <span class="relative flex items-center">Kirim Aspirasi<svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>
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
        let deviceToken = localStorage.getItem('survey_device_token');
        if (!deviceToken) {
            deviceToken = 'DEV-' + Math.random().toString(36).substring(2, 15) + '-' + Date.now();
            localStorage.setItem('survey_device_token', deviceToken);
        }
        const deviceInput = document.getElementById('device_id');
        if (deviceInput) { deviceInput.value = deviceToken; }
        const prodiSelect = document.getElementById('prodi_select');
        const kelasSelect = document.getElementById('kelas_select');
        const kelasOptions = document.querySelectorAll('.kelas-option');
        function filterKelas() {
            const selectedProdi = prodiSelect.value;
            kelasSelect.value = "";
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
            kelasOptions.forEach(option => {
                if (option.getAttribute('data-prodi') === selectedProdi) {
                    option.hidden = false;
                } else {
                    option.hidden = true;
                }
            });
        }
        prodiSelect.addEventListener('change', filterKelas);
        if(prodiSelect.value) {
            const oldKelas = "{{ old('kelas') }}";
            filterKelas();
            if(oldKelas) { kelasSelect.value = oldKelas; }
        }
    });
    </script>
</x-app-layout>