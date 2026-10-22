<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminClassController extends Controller
{
    public function index()
    {
        // LOGIKA JOIN DATABASE
        // 1. Ambil data dari 'master_kelas' sebagai tabel UTAMA
        // 2. Lakukan LEFT JOIN ke 'survey_responses'
        //    (Artinya: Ambil semua kelas di master, meskipun belum ada respon di survei)
        
        $stats = DB::table('master_kelas')
            ->leftJoin('survey_responses', 'master_kelas.kelas', '=', 'survey_responses.kelas')
            ->select(
                'master_kelas.prodi',
                'master_kelas.kelas',
                'master_kelas.total_mahasiswa', // Ambil target fix dari database master
                // Hitung ID survei yang masuk (akan otomatis 0 jika tidak ada respon karena left join)
                DB::raw('COUNT(survey_responses.id) as total_responden') 
            )
            ->groupBy('master_kelas.prodi', 'master_kelas.kelas', 'master_kelas.total_mahasiswa')
            ->orderBy('master_kelas.prodi', 'asc')
            ->orderBy('master_kelas.kelas', 'asc')
            ->get();

        // Grouping berdasarkan prodi untuk tampilan di Blade
        $groupedData = $stats->groupBy('prodi');

        return view('admin.class', compact('groupedData'));
    }
}