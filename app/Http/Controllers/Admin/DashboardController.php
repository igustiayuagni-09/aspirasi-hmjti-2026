<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller {
    public function index(Request $request) {
        // 1. INPUT & FILTER
        // Ubah default month ke 'all' agar sesuai tampilan "Periode Tahun X"
        $year  = (int) $request->input('year', now()->year);
        $month = $request->input('month', 'all'); 
        $kelas = $request->input('kelas');
        $prodi = $request->input('prodi');

        // 2. QUERY DASAR
        $baseQuery = SurveyResponse::query()->whereYear('created_at', $year);
        
        // Filter Bulan (hanya jika ada request spesifik, defaultnya 'all')
        if ($month !== 'all') {
            $baseQuery->whereMonth('created_at', (int) $month);
        }
        
        if ($kelas) $baseQuery->where('kelas', $kelas);
        if ($prodi) $baseQuery->where('prodi', $prodi);

        // 3. HITUNG TOTAL
        $totalResponden = (clone $baseQuery)->count();
        $summary = ['total_responden' => $totalResponden];

        // 4. MAPPING KATEGORI
        $map = [
            'admin'         => ['col' => 'pelayanan_administrasi',   'fb' => 'admin_feedback'],
            'kbm'           => ['col' => 'kegiatan_belajar_mengajar', 'fb' => 'kbm_feedback'],
            'pelayanan_lab' => ['col' => 'pelayanan_lab',            'fb' => 'pelayanan_lab_feedback'],
            'fasilitas_lab' => ['col' => 'fasilitas_lab',            'fb' => 'fasilitas_lab_feedback'],
            'kinerja_hmj'   => ['col' => 'kinerja_hmj',              'fb' => 'kinerja_hmj_feedback'],
            'proker_hmj'    => ['col' => 'proker_hmj',               'fb' => 'proker_hmj_feedback'],
        ];

        $grouped_aspirations = [];

        // 5. LOOPING DATA STATISTIK & ASPIRASI
        if ($totalResponden > 0) {
            foreach ($map as $key => $config) {
                // Hitung Persentase
                $counts = [
                    'baik'   => (clone $baseQuery)->where($config['col'], 'baik')->count(),
                    'cukup'  => (clone $baseQuery)->where($config['col'], 'cukup')->count(),
                    'kurang' => (clone $baseQuery)->where($config['col'], 'kurang')->count(),
                ];
                
                $summary["persentase_baik_{$key}"]   = round(($counts['baik'] / $totalResponden) * 100, 1);
                $summary["persentase_cukup_{$key}"]  = round(($counts['cukup'] / $totalResponden) * 100, 1);
                $summary["persentase_kurang_{$key}"] = round(($counts['kurang'] / $totalResponden) * 100, 1);

                // Ambil Aspirasi (Di-alias-kan menjadi 'aspirasi' agar mudah dipanggil di view)
                $grouped_aspirations[$key] = (clone $baseQuery)
                    ->whereNotNull($config['fb'])
                    ->where($config['fb'], '!=', '')
                    ->select(
                        $config['fb'] . ' as aspirasi', // PENTING: Alias ke 'aspirasi'
                        'created_at', 
                        'device_hash', 
                        'kelas', 
                        'prodi'
                    ) 
                    ->latest()
                    ->take(10)
                    ->get();
            }
        } else {
            // Set default 0 jika tidak ada responden
            foreach ($map as $key => $config) {
                $summary["persentase_baik_{$key}"]   = 0;
                $summary["persentase_cukup_{$key}"]  = 0;
                $summary["persentase_kurang_{$key}"] = 0;
            }
        }

        // 6. RETURN VIEW
        // Variabel $months dihapus karena slider bulan sudah tidak ada
        return view('admin.dashboard', compact(
            'summary', 
            'grouped_aspirations', 
            'year', 
            'month', 
            'kelas', 
            'prodi'
        ));
    }
}