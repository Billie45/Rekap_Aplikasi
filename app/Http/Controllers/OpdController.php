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

        return view('opd.form-pengajuan-assessment', [
            'opdId' => $opd?->id,
            'namaOpd' => $opd?->nama_opd ?? '',
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
        // $user =  Auth::user();

        // $opds = Opd::all();

        // if ($user->role === 'admin') {
        //     $aplikasis = RekapAplikasi::with('opd')
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(15);
        // } else {
        //     $aplikasis = RekapAplikasi::with('opd')
        //         ->where('opd_id', $user->opd_id)
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(15);
        // }

        // return view('./opd.daftar-pengajuan-assessment', compact('aplikasis', 'opds'));

         $query = RekapAplikasi::with('opd');

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
        $apk = RekapAplikasi::with('opd')->findOrFail($id);
        return view('opd.show-apk', compact('apk'));
    }
}
