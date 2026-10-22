<?php

namespace App\Http\Controllers;

use App\Models\MasterKelas;
use Illuminate\Http\Request;

class MasterKelasController extends Controller
{
    // Menampilkan daftar kelas (DISESUAIKAN UNTUK VIEW BARU)
    public function index()
    {
        // Menggunakan withCount untuk menghitung langsung dari database
    $allClasses = MasterKelas::orderBy('prodi', 'asc')
        ->orderBy('kelas', 'asc')
        ->withCount([
            'survei as total_responden',
            
            // CONTOH: Kita ambil statistik kolom 'pelayanan_administrasi'
            // Pastikan value 'Baik', 'Cukup', 'Kurang' sesuai persis dengan apa yang disimpan database
            'survei as hasil_baik' => function ($query) {
                $query->where('pelayanan_administrasi', 'Baik'); 
            },
            'survei as hasil_cukup' => function ($query) {
                $query->where('pelayanan_administrasi', 'Cukup');
            },
            'survei as hasil_kurang' => function ($query) {
                $query->where('pelayanan_administrasi', 'Kurang');
            }
        ])
        ->get();

    $groupedData = $allClasses->groupBy('prodi');
                                
    return view('admin.master-kelas.index', compact('groupedData'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('admin.master-kelas.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'prodi' => 'required|string',
            'kelas' => 'required|string|unique:master_kelas,kelas', // Kelas harus unik
            'total_mahasiswa' => 'required|integer|min:1',
        ]);

        MasterKelas::create($request->all());

        return redirect()->route('admin.master-kelas.index')
                         ->with('success', 'Data kelas berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $kelas = MasterKelas::findOrFail($id);
        return view('admin.master-kelas.edit', compact('kelas'));
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $request->validate([
            'prodi' => 'required|string',
            // Validasi unik kecuali untuk ID ini sendiri
            'kelas' => 'required|string|unique:master_kelas,kelas,'.$id, 
            'total_mahasiswa' => 'required|integer|min:1',
        ]);

        $kelas = MasterKelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.master-kelas.index')
                         ->with('success', 'Data kelas berhasil diperbarui');
    }

    // Menghapus data
    public function destroy($id)
    {
        $kelas = MasterKelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.master-kelas.index')
                         ->with('success', 'Data kelas berhasil dihapus');
    }
}