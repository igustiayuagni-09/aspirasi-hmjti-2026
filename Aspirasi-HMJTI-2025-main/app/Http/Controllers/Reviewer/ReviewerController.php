<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveyResponse;

class ReviewerController extends Controller
{
    public function dashboard(Request $request)
    {
        // ===============================
        // 0. FILTER (SINGLE SOURCE)
        // ===============================
        $currentYear  = (int) $request->input('year', now()->year);
        $currentMonth = $request->input('month', now()->month);
        $isAllMonth   = $currentMonth === 'all';

        $kelas = $request->input('kelas'); // optional
        $prodi = $request->input('prodi'); // optional

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        // ===============================
        // BASE QUERY
        // (VISIBLE + WAKTU + KELAS/PRODI)
        // ===============================
        $baseQuery = SurveyResponse::query()
            ->visible()
            ->whereYear('created_at', $currentYear);

        if (! $isAllMonth) {
            $baseQuery->whereMonth('created_at', (int) $currentMonth);
        }

        if (! empty($kelas)) {
            $baseQuery->where('kelas', $kelas);
        }

        if (! empty($prodi)) {
            $baseQuery->where('prodi', $prodi);
        }

        // ===============================
        // 1. TOTAL RESPONDEN
        // ===============================
        $totalResponden = (clone $baseQuery)->count();

        $summary = [
            'total_responden' => $totalResponden,
        ];

        if ($totalResponden === 0) {
            return view('reviewer.dashboard', compact(
                'summary',
                'months',
                'currentMonth',
                'currentYear',
                'isAllMonth',
                'kelas',
                'prodi'
            ));
        }

        // ===============================
        // 2. HITUNG PERSENTASE
        // ===============================
        $map = [
            'admin'         => 'pelayanan_administrasi',
            'kbm'           => 'kegiatan_belajar_mengajar',
            'pelayanan_lab' => 'pelayanan_lab',
            'fasilitas_lab' => 'fasilitas_lab',
            'kinerja_hmj'   => 'kinerja_hmj',
            'proker_hmj'    => 'proker_hmj',
        ];

        foreach ($map as $prefix => $column) {
            $counts = [
                'baik'   => (clone $baseQuery)->where($column, 'baik')->count(),
                'cukup'  => (clone $baseQuery)->where($column, 'cukup')->count(),
                'kurang' => (clone $baseQuery)->where($column, 'kurang')->count(),
            ];

            $this->calculatePercentages(
                $summary,
                $prefix,
                $counts,
                $totalResponden
            );
        }

        // ===============================
        // 3. ASPIRASI TERBARU (VISIBLE)
        // ===============================
        $recent_aspirations = (clone $baseQuery)
            ->withAnyFeedback()
            ->latest()
            ->take(20)
            ->get();

        // ===============================
        // 4. GROUPING UNTUK VIEW
        // ===============================
        $grouped_aspirations = [];
        foreach ($map as $prefix => $column) {
            $grouped_aspirations[$prefix] = $recent_aspirations;
        }

        return view('reviewer.dashboard', compact(
            'summary',
            'grouped_aspirations',
            'months',
            'currentMonth',
            'currentYear',
            'isAllMonth',
            'kelas',
            'prodi'
        ));
    }

    /**
     * Helper: Hitung persentase
     */
    protected function calculatePercentages(
        array &$summary,
        string $prefix,
        array $counts,
        int $totalResponden
    ): void {
        if ($totalResponden === 0) {
            $summary["persentase_baik_{$prefix}"]   = 0;
            $summary["persentase_cukup_{$prefix}"]  = 0;
            $summary["persentase_kurang_{$prefix}"] = 0;
            return;
        }

        $summary["persentase_baik_{$prefix}"]   = round(($counts['baik'] / $totalResponden) * 100, 1);
        $summary["persentase_cukup_{$prefix}"]  = round(($counts['cukup'] / $totalResponden) * 100, 1);
        $summary["persentase_kurang_{$prefix}"] = round(($counts['kurang'] / $totalResponden) * 100, 1);
    }
}
