<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapAplikasi;
use App\Models\Opd;

class ViewAplikasiController extends Controller
{
    // public function dashboard()
    // {
    //     $aplikasis = RekapAplikasi::with('opd')->get();
    //     $opds = Opd::all();
    //     return view('components.rekap-assessment-1',  compact('aplikasis', 'opds'));
    // }

    public function rekap()
    {
        $aplikasis = RekapAplikasi::with('opd')->orderBy('created_at', 'desc')->paginate(20);
        $opds = Opd::all();
        return view('pages.rekap',  compact('aplikasis', 'opds'));
    }

    public function assessment()
    {
        $aplikasis = RekapAplikasi::with('opd')
                          ->whereIn('status', ['perbaikan', 'assessment1', 'assessment2'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);
        $opds = Opd::all();
        return view('pages.assessment',  compact('aplikasis', 'opds'));
    }

    public function development()
    {

        $aplikasis = RekapAplikasi::with('opd')
                          ->whereIn('status', ['development', 'prosesBA'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);
        $opds = Opd::all();
        return view('pages.development',  compact('aplikasis', 'opds'));
    }

    public function selesai()
    {
        $aplikasis = RekapAplikasi::with('opd')
                          ->whereIn('status', ['selesai', 'batal'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);
        $opds = Opd::all();
        return view('pages.selesai',  compact('aplikasis', 'opds'));
    }

    public function aksesServer()
    {
        $aplikasis = RekapAplikasi::with('opd')->orderBy('created_at', 'desc')->paginate(20);
        $opds = Opd::all();
        return view('pages.server',  compact('aplikasis', 'opds'));
    }
}

