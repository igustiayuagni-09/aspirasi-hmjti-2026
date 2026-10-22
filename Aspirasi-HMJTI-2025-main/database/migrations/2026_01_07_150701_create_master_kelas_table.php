<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_kelas', function (Blueprint $table) {
        $table->id();
        $table->string('prodi');          // Contoh: 'Teknik Informatika'
        $table->string('kelas')->unique(); // Contoh: 'TI-1A' (Harus unik)
        $table->integer('total_mahasiswa'); // Contoh: 30
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kelas');
    }
};
