<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatRevisiAssessment extends Model
{
    use HasFactory;

    protected $table = 'riwayat_revisi_assessment';

    protected $fillable = [
        'rekap_aplikasi_id',
        'permohonan',
        'opd_id',
        'jenis',
        'nama',
        'subdomain',
        'tipe',
        'jenis_permohonan',
        'link_dokumentasi',
        'akun_link',
        'akun_username',
        'akun_password',
        'cp_opd_nama',
        'cp_opd_no_telepon',
        'cp_pengembang_nama',
        'cp_pengembang_no_telepon',
        'surat_permohonan',
        'tanggal_pengajuan',
        'catatan',
    ];

    public function rekapAplikasi()
    {
        return $this->belongsTo(RekapAplikasi::class);
    }
}
