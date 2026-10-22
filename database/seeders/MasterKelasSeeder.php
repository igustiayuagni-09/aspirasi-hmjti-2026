<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tips: Untuk input data banyak, gunakan array seperti ini
        $data = [
            // --- PRODI MANAJEMEN INFORMATIKA (MI) ---
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-1A', 'total_mahasiswa' => 30],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-1B', 'total_mahasiswa' => 29],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-1C', 'total_mahasiswa' => 30],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-3A', 'total_mahasiswa' => 28],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-3B', 'total_mahasiswa' => 27],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-3C', 'total_mahasiswa' => 28],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-5A', 'total_mahasiswa' => 27],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-5B', 'total_mahasiswa' => 26],
            ['prodi' => 'Manajemen Informatika', 'kelas' => 'MI-5C', 'total_mahasiswa' => 25],

            // --- PRODI Teknologi Rekayasa Perangkat Lunak (TRPL) ---
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-1A', 'total_mahasiswa' => 32],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-1B', 'total_mahasiswa' => 31],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-1C', 'total_mahasiswa' => 30],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-3A', 'total_mahasiswa' => 25],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-3B', 'total_mahasiswa' => 24],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-3C', 'total_mahasiswa' => 23],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-5A', 'total_mahasiswa' => 24],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-5B', 'total_mahasiswa' => 25],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-5C', 'total_mahasiswa' => 28],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-7A', 'total_mahasiswa' => 23],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-7B', 'total_mahasiswa' => 22],
            ['prodi' => 'Teknologi Rekayasa Perangkat Lunak', 'kelas' => 'TRPL-7C', 'total_mahasiswa' => 21],
            
        ];

        // Masukkan data ke tabel
        DB::table('master_kelas')->insert($data);
    }
}
