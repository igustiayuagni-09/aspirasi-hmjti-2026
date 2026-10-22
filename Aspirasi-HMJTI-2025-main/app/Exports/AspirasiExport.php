<?php

namespace App\Exports;

use App\Models\SurveyResponse;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AspirasiExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function query()
    {
        return SurveyResponse::query();
    }

    // Mapping Data dari Database ke Kolom Excel
    public function map($aspirasi): array
    {
        // PERUBAHAN 2: Menghapus logika pengambilan nama user
        
        return [
            // 1. Tanggal Input
            \Carbon\Carbon::parse($aspirasi->created_at)->translatedFormat('d F Y H:i'),

            // 2. Administrasi
            $aspirasi->pelayanan_administrasi ?? '-', // Skor
            $aspirasi->admin_feedback ?? '-',         // Masukan

            // 3. KBM
            $aspirasi->kegiatan_belajar_mengajar ?? '-',
            $aspirasi->kbm_feedback ?? '-',
            // 4. Pelayanan Lab
            $aspirasi->pelayanan_lab ?? '-',
            $aspirasi->pelayanan_lab_feedback ?? '-',

            // 5. Fasilitas Lab
            $aspirasi->fasilitas_lab ?? '-',
            $aspirasi->fasilitas_lab_feedback ?? '-',

            // 6. Kinerja HMJ
            $aspirasi->kinerja_hmj ?? '-',
            $aspirasi->kinerja_hmj_feedback ?? '-',
            // 7. Program Kerja HMJ
            $aspirasi->proker_hmj ?? '-',
            $aspirasi->proker_hmj_feedback ?? '-',
        ];
    }

    // Judul Header Kolom di Excel
    public function headings(): array
    {
        return [
            'Waktu Pengisian',
            'Skor Admin',
            'Masukan Admin',
            'Skor KBM',
            'Masukan KBM',
            'Skor Layanan Lab',
            'Masukan Layanan Lab',
            'Skor Fasilitas Lab',
            'Masukan Fasilitas Lab',
            'Skor Kinerja HMJ',
            'Masukan Kinerja HMJ',
            'Skor Proker HMJ',
            'Masukan Proker HMJ',
        ];
    }

    // Styling Header (Bold)
    public function styles(Worksheet $sheet)
    {
        // 1. Ambil baris terakhir yang ada datanya
        $lastRow = $sheet->getHighestRow();
        
        // 2. Buat range dari A1 sampai kolom terakhir (M) dan baris terakhir
        $range = 'A1:M' . $lastRow; 

        return [
            // Style untuk Header (Baris 1)
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFCCCCCC'], // Warna abu-abu
                ],
            ],

            // Style untuk Seluruh Tabel (Memberi Garis Batas/Border)
            $range => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
                'alignment' => ['vertical' => 'center'], // Teks rata tengah secara vertikal
            ],
        ];
    }
}