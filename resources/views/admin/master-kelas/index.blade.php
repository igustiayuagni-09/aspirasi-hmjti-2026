@extends('layouts.admin')

@section('title', 'Manajemen Data Kelas')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Master Data Kelas</h2>
            {{-- Total Counter --}}
            <p class="text-sm text-gray-500">Total {{ $groupedData->flatten()->count() }} kelas terdaftar.</p>
        </div>
        {{-- Tombol Tambah (Memicu Modal) --}}
        <button onclick="openModal('create')" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kelas
        </button>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div id="alert-box" class="bg-green-50 text-green-700 p-4 rounded-xl border border-green-200 flex items-center shadow-sm relative">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
        <button onclick="document.getElementById('alert-box').remove()" class="absolute right-4 text-green-400 hover:text-green-600">x</button>
    </div>
    @endif

    {{-- Grid View --}}
    @if($groupedData->count() > 0)
        @foreach($groupedData as $prodiName => $kelasItems)
            <div class="space-y-4">
                {{-- Judul Prodi --}}
                <div class="flex items-center space-x-2 border-b border-gray-200 pb-2">
                    <div class="h-6 w-1 {{ str_contains(strtoupper($prodiName), 'TRPL') ? 'bg-orange-500' : 'bg-blue-600' }} rounded-full"></div>
                    <h3 class="text-lg font-bold text-gray-700">{{ $prodiName }}</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($kelasItems as $item)
                        @php
                            $isTRPL = str_contains(strtoupper($item->prodi), 'TRPL') || str_contains(strtoupper($item->prodi), 'REKAYASA');
                            $badgeColor = $isTRPL ? 'bg-orange-50 text-orange-600 border-orange-100' : 'bg-blue-50 text-blue-600 border-blue-100';
                            $iconColor  = $isTRPL ? 'text-orange-500' : 'text-blue-500';
                        @endphp

                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group relative overflow-hidden">
                            <div class="relative">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">{{ $item->kelas }}</h3>
                                        <span class="text-[10px] uppercase tracking-wider font-bold border px-2 py-0.5 rounded-full {{ $badgeColor }}">
                                            {{ $isTRPL ? 'TRPL' : 'MI' }}
                                        </span>
                                    </div>

                                    <div class="flex space-x-1">
                                        {{-- Tombol Edit --}}
                                        <button 
                                            onclick="openModal('edit', '{{ $item->id }}', '{{ $item->prodi }}', '{{ $item->kelas }}', '{{ $item->total_mahasiswa }}')"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>

                                        {{-- Tombol Hapus (UPDATED: Memicu Modal Hapus) --}}
                                        <button 
                                            onclick="openDeleteModal('{{ $item->id }}', '{{ $item->kelas }}')"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                                    <span class="text-xs text-gray-400 font-medium">Target Mhs</span>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span class="text-lg font-bold text-gray-700">{{ $item->total_mahasiswa }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
            <p class="mt-2 text-sm text-gray-500">Belum ada data kelas.</p>
        </div>
    @endif
</div>

{{-- ================= MODAL CREATE/EDIT (Hidden by Default) ================= --}}
<div id="crudModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form id="modalForm" method="POST" action="">
                @csrf
                <div id="methodField"></div>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Tambah Kelas Baru</h3>
                            <div class="mt-4 space-y-4">
                                {{-- Input Prodi --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                    <select id="inputProdi" name="prodi" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                        <option value="TRPL">Teknologi Rekayasa Perangkat Lunak</option>
                                        <option value="Manajemen Informatika">Manajemen Informatika</option>
                                    </select>
                                </div>
                                {{-- Input Kelas --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                                    <input type="text" id="inputKelas" name="kelas" placeholder="Contoh: TI-1A" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm uppercase" required>
                                </div>
                                {{-- Input Total --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Mahasiswa</label>
                                    <input type="number" id="inputTotal" name="total_mahasiswa" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" min="1" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" id="submitBtn" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL DELETE (New) ================= --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDeleteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Hapus Kelas?</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Apakah Anda yakin ingin menghapus data kelas <span class="font-bold text-gray-800" id="deleteClassName"></span>? 
                                Data yang dihapus tidak dapat dikembalikan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Ya, Hapus
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>
    // --- Create/Edit Modal Variables ---
    const modal = document.getElementById('crudModal');
    const form = document.getElementById('modalForm');
    const title = document.getElementById('modalTitle');
    const btn = document.getElementById('submitBtn');
    const methodField = document.getElementById('methodField');

    // --- Delete Modal Variables ---
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteClassName = document.getElementById('deleteClassName');

    // --- Base URLs ---
    const baseUrl = "{{ route('admin.master-kelas.index') }}"; 
    const storeUrl = "{{ route('admin.master-kelas.store') }}";

    // Function: Create & Edit Modal
    function openModal(mode, id = null, prodi = '', kelas = '', total = '') {
        modal.classList.remove('hidden');

        if (mode === 'create') {
            title.innerText = 'Tambah Kelas Baru';
            btn.innerText = 'Simpan';
            form.action = storeUrl;
            methodField.innerHTML = ''; 
            
            document.getElementById('inputProdi').value = 'TRPL';
            document.getElementById('inputKelas').value = '';
            document.getElementById('inputTotal').value = '';

        } else {
            title.innerText = 'Edit Kelas ' + kelas;
            btn.innerText = 'Update Data';
            form.action = baseUrl + '/' + id;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('inputProdi').value = prodi;
            document.getElementById('inputKelas').value = kelas;
            document.getElementById('inputTotal').value = total;
        }
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    // Function: Delete Modal
    function openDeleteModal(id, name) {
        deleteModal.classList.remove('hidden');
        deleteClassName.innerText = name;
        // Set action form ke URL delete: /admin/master-kelas/{id}
        deleteForm.action = baseUrl + '/' + id; 
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }
</script>
@endsection