<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
use Illuminate\Support\Facades\Auth;
use App\Models\RekapAplikasi;

class OpdController extends Controller
{
    public function dashboard()
    {
        $aplikasis = RekapAplikasi::all();
        return view('opd.dashboard', compact('aplikasis'));
    }

    // ================================================================
    // Bagian ini digunakan untuk 'form-pengajuan-assessment' dari OPD
    // ================================================================
    //
    // Start
    public function formPengajuan()
    {
        $user =  Auth::user();

        $namaOpd = $user->opd ? $user->opd->nama_opd : null;

        return view('opd.form-pengajuan-assessment', compact('namaOpd'));
    }
    //
    // end

    // ==================================================================
    // Bagian ini digunakan untuk 'daftar-pengajuan-assessment' dari OPD
    // ==================================================================
    //
    // Start
    public function daftarPengajuan()
    {
        $user =  Auth::user();

        $opds = Opd::all();

        if ($user->role === 'admin') {
            $aplikasis = RekapAplikasi::with('opd')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $aplikasis = RekapAplikasi::with('opd')
                ->where('opd_id', $user->opd_id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('./opd.daftar-pengajuan-assessment', compact('aplikasis', 'opds'));
    }
    //
    // end
}
