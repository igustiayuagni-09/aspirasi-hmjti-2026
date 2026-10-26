<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'device_hash', 'kelas', 'prodi',
        'pelayanan_administrasi', 'kegiatan_belajar_mengajar', 'pelayanan_lab', 'fasilitas_lab', 'kinerja_hmj', 'proker_hmj',
        'admin_feedback', 'kbm_feedback', 'pelayanan_lab_feedback', 'fasilitas_lab_feedback', 'kinerja_hmj_feedback', 'proker_hmj_feedback',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Scope untuk mengambil feedback yang tidak kosong dan diizinkan tampil (untuk Reviewer/Publik)
    public function scopeVisibleFeedback($query, $column, $visibilityColumn) {
        return $query->whereNotNull($column)
                     ->where($column, '!=', '')
                     ->where($visibilityColumn, true);
    }

    public function scopeWithAnyFeedback($query) {
        return $query->where(function ($q) {
            $q->where('admin_feedback', '!=', '')->orWhere('kbm_feedback', '!=', '')
              ->orWhere('pelayanan_lab_feedback', '!=', '')->orWhere('fasilitas_lab_feedback', '!=', '')
              ->orWhere('kinerja_hmj_feedback', '!=', '')->orWhere('proker_hmj_feedback', '!=', '');
        });
    }
}