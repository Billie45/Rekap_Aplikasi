<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RevisiPenilaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'penilaian_id',
        'catatan_revisi',
        'dokumen_revisi',
        'dokumen_laporan',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the penilaian that owns the revision
     */
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
