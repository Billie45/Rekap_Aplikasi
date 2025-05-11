<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapAplikasi;
use App\Models\Opd;

class ViewAplikasiController extends Controller
{
    // =========================================================
    // digunakan untuk view pages
    // =========================================================
    // - rekap
    // - assessment
    // - development
    // - selesai
    // - akses server
    // =========================================================
    //
    // Start
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
    //
    // end

    // =========================================================
    // Bagian ini melanjutkan views dimana masuk ke detail
    // =========================================================
    // - detail assessment
    // - detail rekap
    // - detail development
    // - detail selesai
    // =========================================================
    //
    // Start
    public function show_assessmet($id)
    {
        $apk = RekapAplikasi::with('opd')->findOrFail($id);
        return view('pages.details.show-assessment', compact('apk'));
    }

    public function show_rekap($id)
    {
        $apk = RekapAplikasi::with('opd')->findOrFail($id);
        return view('pages.details.show-rekap', compact('apk'));
    }

    public function show_development($id)
    {
        $apk = RekapAplikasi::with('opd')->findOrFail($id);
        return view('pages.details.show-development', compact('apk'));
    }

    public function show_selesai($id)
    {
        $apk = RekapAplikasi::with('opd')->findOrFail($id);
        return view('pages.details.show-selesai', compact('apk'));
    }
    //
    // end
}

