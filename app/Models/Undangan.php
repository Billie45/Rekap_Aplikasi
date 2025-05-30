<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Undangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekap_aplikasi_id',
        'tanggal_assessment',
        'surat_undangan',
        'link_zoom_meeting',
        'tanggal_zoom_meeting',
        'waktu_zoom_meeting',
        'tempat',
    ];

    public function rekapAplikasi()
    {
        return $this->belongsTo(RekapAplikasi::class, 'rekap_aplikasi_id');
    }
}
