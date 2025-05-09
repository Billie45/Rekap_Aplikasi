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

    public function formPengajuan()
    {
        $user =  Auth::user();

        $namaOpd = $user->opd ? $user->opd->nama_opd : null;

        return view('opd.form-pengajuan-assessment', compact('namaOpd'));
    }

    public function daftarPengajuan()
    {
        $aplikasis = RekapAplikasi::with('opd')->orderBy('created_at', 'desc')->paginate(15);
        $opds = Opd::all();

        return view('./opd.daftar-pengajuan-assessment', compact('aplikasis', 'opds'));
    }
}
