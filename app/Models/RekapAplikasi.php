<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class RekapAplikasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rekap_aplikasi';

    // Untuk Sotf delete
    //
    // start
    protected $dates = ['deleted_at'];
    // end

    protected $fillable = [
        'nama',
        'opd_id',
        'subdomain',
        'tipe',
        'jenis',
        'status',
        'server',
        'keterangan',
        'last_update',
        'jenis_permohonan',
        'tanggal_masuk_ba',
        'link_dokumentasi',
        'akun_link',
        'akun_username',
        'akun_password',
        'cp_opd_nama',
        'cp_opd_no_telepon',
        'cp_pengembang_nama',
        'cp_pengembang_no_telepon',
        'assesment_terakhir',
        'permohonan',
        'undangan_terakhir',
        'laporan_perbaikan',
        'status_server',
        'open_akses',
        'close_akses',
        'urgensi'
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function getTipeLabelAttribute()
    {
        return match ($this->tipe) {
            'apk' => 'Aplikasi Web',
            'web' => 'Website',
            default => '-',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'diproses' => 'Diproses',
            'perbaikan' => 'Perbaikan',
            'assessment1' => 'Assessment 1',
            'assessment2' => 'Assessment 2',
            'development' => 'Development',
            'prosesBA' => 'Proses BA',
            'selesai' => 'Selesai',
            'batal' => 'Batal',
            default => '-',
        };
    }
}
