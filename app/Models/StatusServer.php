<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusServer extends Model
{
    protected $fillable = [
        'penilaian_id',
        'nama_server',
        'tanggal_masuk_server',
        'status_server',
        'permohonan',
        'dokumen_teknis',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
