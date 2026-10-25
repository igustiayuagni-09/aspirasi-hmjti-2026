<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            // Nullable karena user bisa anonim, atau isi via publik
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('device_hash')->unique()->nullable(); // Untuk cegah double submit anonim

            $table->string('kelas');
            $table->string('prodi');

            // Penilaian - 11 Soal
            $table->enum('pelayanan_administrasi', ['baik','cukup','kurang']);
            $table->enum('informasi_administrasi', ['baik','cukup','kurang']);
            $table->enum('pelaksanaan_kbm', ['baik','cukup','kurang']);
            $table->enum('kenyamanan_kelas', ['baik','cukup','kurang']);
            $table->enum('fasilitas_lab', ['baik','cukup','kurang']);
            $table->enum('ruang_lab', ['baik','cukup','kurang']);
            $table->enum('fasilitas_kampus', ['baik','cukup','kurang']);
            $table->enum('fasilitas_penunjang', ['baik','cukup','kurang']);
            $table->enum('kinerja_hmj', ['baik','cukup','kurang']);
            $table->enum('transparansi_hmj', ['baik','cukup','kurang']);
            $table->enum('proker_hmj', ['baik','cukup','kurang']);

            // Feedback - Saran per Soal
            $table->text('pelayanan_administrasi_feedback')->nullable();
            $table->text('informasi_administrasi_feedback')->nullable();
            $table->text('pelaksanaan_kbm_feedback')->nullable();
            $table->text('kenyamanan_kelas_feedback')->nullable();
            $table->text('fasilitas_lab_feedback')->nullable();
            $table->text('ruang_lab_feedback')->nullable();
            $table->text('fasilitas_kampus_feedback')->nullable();
            $table->text('fasilitas_penunjang_feedback')->nullable();
            $table->text('kinerja_hmj_feedback')->nullable();
            $table->text('transparansi_hmj_feedback')->nullable();
            $table->text('proker_hmj_feedback')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('survey_responses');
    }
};