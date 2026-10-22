<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SurveyResponse;

class MasterKelas extends Model
{
    use HasFactory;

    protected $table = 'master_kelas';
    protected $guarded = [];

    // === TAMBAHKAN INI ===
    public function survei()
    {
        // Asumsi: 
        // 1. Anda punya model bernama 'Survei' (App\Models\Survei)
        // 2. Di tabel 'surveis', ada kolom 'kelas' yang isinya sama dengan 'kelas' di tabel ini (misal: "TI-1A")
        // Jika penghubungnya ID, ganti 'kelas', 'kelas' menjadi 'master_kelas_id', 'id'

        return $this->hasMany(SurveyResponse::class, 'kelas', 'kelas');
    }
}
