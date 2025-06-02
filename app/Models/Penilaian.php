<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekap_aplikasi_id',
        'dokumen_hasil_assessment',
        'tanggal_deadline_perbaikan',
        'keputusan_assessment',
    ];

    protected $casts = [
        'tanggal_deadline_perbaikan' => 'date',
    ];

    public function rekapAplikasi()
    {
        return $this->belongsTo(RekapAplikasi::class);
    }

    public function penilaianFotos()
    {
        return $this->hasMany(PenilaianFoto::class);
    }
    public function ba()
    {
        return $this->hasOne(BA::class);
    }

    /**
     * Get the revisions for the penilaian
     */
    public function revisiPenilaians()
    {
        return $this->hasMany(RevisiPenilaian::class);
    }

    public function statusServer()
    {
        return $this->hasOne(StatusServer::class);
    }
}
