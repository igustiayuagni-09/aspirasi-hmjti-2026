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

            // Penilaian
            $table->enum('pelayanan_administrasi', ['baik','cukup','kurang']);
            $table->enum('kegiatan_belajar_mengajar', ['baik','cukup','kurang']);
            $table->enum('pelayanan_lab', ['baik','cukup','kurang']);
            $table->enum('fasilitas_lab', ['baik','cukup','kurang']);
            $table->enum('kinerja_hmj', ['baik','cukup','kurang']);
            $table->enum('proker_hmj', ['baik','cukup','kurang']);

            // Feedback
            $table->text('admin_feedback')->nullable();
            $table->text('kbm_feedback')->nullable();
            $table->text('pelayanan_lab_feedback')->nullable();
            $table->text('fasilitas_lab_feedback')->nullable();
            $table->text('kinerja_hmj_feedback')->nullable();
            $table->text('proker_hmj_feedback')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('survey_responses');
    }
};