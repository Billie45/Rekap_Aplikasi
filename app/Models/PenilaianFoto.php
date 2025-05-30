<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'penilaian_id',
        'foto'
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
