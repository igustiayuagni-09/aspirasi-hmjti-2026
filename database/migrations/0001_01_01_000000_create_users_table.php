<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // ======================
            // DATA ADMIN
            // ======================
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('role')->default('user'); // admin | user

            // ======================
            // DATA RESPONDEN SURVEI
            // ======================
            $table->string('kelas')->nullable();
            $table->string('prodi')->nullable();

            // Status isi survei (opsional tapi recommended)
            $table->boolean('has_filled_survey')->default(false);

            // ======================
            // SYSTEM
            // ======================
            $table->rememberToken();
            $table->timestamps();
        });

        // Table sessions (biarin default Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
