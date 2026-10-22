<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use App\Models\MasterKelas;
use Illuminate\Database\QueryException;

class SurveyController extends Controller
{
    // Menampilkan Form Survey
    public function index()
    {
        // Ambil semua data kelas
        $allKelas = MasterKelas::orderBy('kelas', 'asc')->get();
        
        // Ambil list prodi yang unik saja untuk dropdown pertama
        $prodiList = $allKelas->pluck('prodi')->unique();
        // Pastikan file ada di resources/views/survey/index.blade.php
        return view('survey.index', compact('allKelas', 'prodiList'));
    }

    // Menyimpan Data Survey
    public function store(Request $request)
{
    // 1. Validasi Input
    $validated = $request->validate([
        'device_id'                 => 'required|string', // Menangkap token dari localStorage
        'kelas'                     => 'required|string',
        'prodi'                     => 'required|string',
        'pelayanan_administrasi'    => 'required|in:baik,cukup,kurang',
        'kegiatan_belajar_mengajar' => 'required|in:baik,cukup,kurang',
        'pelayanan_lab'             => 'required|in:baik,cukup,kurang',
        'fasilitas_lab'             => 'required|in:baik,cukup,kurang',
        'kinerja_hmj'               => 'required|in:baik,cukup,kurang',
        'proker_hmj'                => 'required|in:baik,cukup,kurang',
        'admin_feedback'            => 'nullable|string|max:1000',
        'kbm_feedback'              => 'nullable|string|max:1000',
        'pelayanan_lab_feedback'    => 'nullable|string|max:1000',
        'fasilitas_lab_feedback'    => 'nullable|string|max:1000',
        'kinerja_hmj_feedback'      => 'nullable|string|max:1000',
        'proker_hmj_feedback'       => 'nullable|string|max:1000',
    ]);

    // 2. Gunakan Nilai Asli dari LocalStorage (Tanpa di-hash ulang agar konsisten)
    // Atau jika ingin tetap di-hash untuk privasi:
    $deviceHash = hash('sha256', $validated['device_id']);

    // 3. Cek Duplikasi
    if (SurveyResponse::where('device_hash', $deviceHash)->exists()) {
        return back()
            ->withInput() // Agar data pilihan user tidak hilang
            ->with('error', 'Perangkat ini sudah digunakan untuk mengirim aspirasi.');
    }

    try {
        // 4. Simpan ke Database
        SurveyResponse::create(array_merge($validated, [
            'device_hash' => $deviceHash
        ]));

        return redirect()
            ->route('survey.thankyou')
            ->with('status', 'Terima kasih! Aspirasi Anda berhasil dikirim.');

    } catch (QueryException $e) {
        return back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
    }
}

    // Menampilkan Feedback Publik
    public function feedback()
    {
        $feedbacks = SurveyResponse::withAnyFeedback()->latest()->paginate(10);
        return view('survey.feedback', compact('feedbacks'));
    }
}