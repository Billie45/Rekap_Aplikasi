<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Undangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekap_aplikasi_id',
        'tanggal_undangan',
        'assessment_dokumentasi',
        'catatan_assessment',
        'surat_rekomendasi'
    ];

    public function rekapAplikasi()
    {
        return $this->belongsTo(RekapAplikasi::class, 'rekap_aplikasi_id');
    }
}
