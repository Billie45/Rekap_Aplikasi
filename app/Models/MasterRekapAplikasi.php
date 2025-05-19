<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRekapAplikasi extends Model
{
    protected $table = 'master_rekap_aplikasi';
    protected $fillable = ['nama', 'opd_id'];

    public function aplikasis()
    {
        return $this->hasMany(RekapAplikasi::class, 'master_rekap_aplikasi_id');
    }
}
