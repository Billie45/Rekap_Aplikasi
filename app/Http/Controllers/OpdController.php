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
        // $aplikasis = RekapAplikasi::all();
        // return view('opd.dashboard', compact('aplikasis'));
        $user = Auth::user();
        $opd = $user->opd;

        $aplikasis = RekapAplikasi::with('opd')
            ->where('opd_id', $opd->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $rekap = RekapAplikasi::latest('updated_at')->first();

        return view('opd.dashboard', compact('aplikasis', 'rekap'));
    }

    public function dashboard_view(){
        $aplikasis = RekapAplikasi::all();
        $rekap = RekapAplikasi::latest('updated_at')->first();

        return view('opd.dashboard', compact('aplikasis', 'rekap'));
    }

    // ================================================================
    // Bagian ini digunakan untuk 'form-pengajuan-assessment' dari OPD
    // ================================================================
    //
    // Start
    public function formPengajuan()
    {
        // $user =  Auth::user();

        // $namaOpd = $user->opd ? $user->opd->nama_opd : null;

        // return view('opd.form-pengajuan-assessment', compact('namaOpd'));
        $user = Auth::user();

        if (!$user || !$user->opd) {
            abort(403, 'You must be associated with an OPD to submit this form.');
        }

        $opd = $user->opd;

        $apps = \App\Models\MasterRekapAplikasi::where('opd_id', $opd->id)->get();

        return view('opd.form-pengajuan-assessment', [
            'opdId' => $opd?->id,
            'namaOpd' => $opd?->nama_opd ?? '',
            'apps' => $apps,
        ]);
    }
    //
    // end

    // ==================================================================
    // Bagian ini digunakan untuk 'daftar-pengajuan-assessment' dari OPD
    // ==================================================================
    //
    // Start
    public function daftarPengajuan(Request $request)
    {
        $query = RekapAplikasi::with('opd', 'latestPenilaian');

        // Filter by OPD if user is OPD role
        if (Auth::user()->role == 'opd' && Auth::user()->opd) {
            $query->where('opd_id', Auth::user()->opd->id);
        }

        // Add additional filters if needed
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Paginate the results
        $aplikasis = $query->paginate(25);

        return view('opd.daftar-pengajuan-assessment', compact('aplikasis'));
    }
    //
    // end

    public function showApk($id)
    {
        $apk = RekapAplikasi::with(['opd', 'riwayatRevisiAssessments'])->findOrFail($id);

        $riwayatRevisiAssessment = $apk->riwayatRevisiAssessments->last(); // atau sesuai urutan yang kamu mau
        $riwayatPertama = $apk->riwayatRevisiAssessments()->orderBy('permohonan', 'asc')->first();
        $riwayatTerakhir = $apk->riwayatRevisiAssessments()->orderBy('permohonan', 'desc')->first();

        $riwayatPengembangan = RekapAplikasi::where('master_rekap_aplikasi_id', $apk->master_rekap_aplikasi_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('opd.show-apk', compact('apk', 'riwayatPengembangan', 'riwayatRevisiAssessment', 'riwayatPertama', 'riwayatTerakhir'));
    }

}
