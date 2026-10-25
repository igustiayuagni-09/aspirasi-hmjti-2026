<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
        'user_id',
        'master_kelas_id',
        
        // 11 Penilaian
        'pelayanan_administrasi',
        'informasi_administrasi',
        'pelaksanaan_kbm',
        'kenyamanan_kelas',
        'fasilitas_lab',
        'ruang_lab',
        'fasilitas_kampus',
        'fasilitas_penunjang',
        'kinerja_hmj',
        'transparansi_hmj',
        'proker_hmj',

        // 11 Feedback per Soal
        'pelayanan_administrasi_feedback',
        'informasi_administrasi_feedback',
        'pelaksanaan_kbm_feedback',
        'kenyamanan_kelas_feedback',
        'fasilitas_lab_feedback',
        'ruang_lab_feedback',
        'fasilitas_kampus_feedback',
        'fasilitas_penunjang_feedback',
        'kinerja_hmj_feedback',
        'transparansi_hmj_feedback',
        'proker_hmj_feedback',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function masterKelas()
    {
        return $this->belongsTo(MasterKelas::class);
    }
}