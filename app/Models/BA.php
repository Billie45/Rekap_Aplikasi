<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BA extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bas';

    protected $fillable = [
        'penilaian_id',
        'tanggal_pelaksanaan',
        'ringkasan_hasil',
        'dokumen_ba',
    ];

    protected $dates = [
        'tanggal_pelaksanaan',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date'
    ];
    /**
     * Get the penilaian that owns the BA
     */
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }

    /**
     * Get the dokumen BA URL attribute
     */
    public function getDokumenBaUrlAttribute()
    {
        return $this->dokumen_ba ? asset('storage/' . $this->dokumen_ba) : null;
    }
}
