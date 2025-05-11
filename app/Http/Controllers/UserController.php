<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\RekapAplikasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $aplikasis = RekapAplikasi::all();
        return view('user.dashboard', compact('aplikasis'));
    }

    // ============================================================
    // bagian ini digunakan user untuk mengajukan diri menjadi OPD
    // ============================================================
    // Karena Revisi Tidak jadi dipakai
    // ============================================================
    //
    // Start
    public function showPengajuanForm()
    {
        $opds = Opd::all();
        return view('user.pengajuan-opd', compact('opds'));
    }

    public function submitPengajuan(Request $request)
    {
        $request->validate([
            'opd_id' => 'required|exists:opds,id',
        ]);

        $opd = Opd::find($request->opd_id);

        $existingUser = User::where('opd_id', $opd->id)
                            ->where('status_pengajuan', 'approved')
                            ->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'OPD ini sudah digunakan oleh pengguna lain.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->opd_id = $request->opd_id;
        $user->status_pengajuan = 'pending';

        $user->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim!');
    }
    //
    // end
}
