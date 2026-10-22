<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    /** @test */
    public function halaman_utama_bisa_diakses_dan_status_ok()
    {
        // 1. Kunjungi URL '/'
        $response = $this->get('/');

        // 2. Pastikan statusnya 200 (OK)
        $response->assertStatus(200);
    }

    /** @test */
    public function halaman_utama_memiliki_teks_laravel()
    {
        // 1. Kunjungi URL
        $response = $this->get('/');

        // 2. Pastikan di layar ada tulisan 'Aspirasi Mahasiswa Teknologi Informasi 2025'
        // (Sesuaikan dengan teks yang ada di welcome.blade.php Anda)
        $response->assertSee('Aspirasi Mahasiswa Teknologi Informasi 2025');
    }
}