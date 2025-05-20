<?php

namespace App\Http\Controllers;

use App\Models\MasterRekapAplikasi;
use Illuminate\Http\Request;
use App\Models\RekapAplikasi;

use App\Models\User;
use App\Models\Opd;

class AdminController extends Controller
{
    // =========================================================
    // digunakan untuk view pages
    // =========================================================
    //
    // Start
    public function dashboard()
    {
        $aplikasis = RekapAplikasi::all();
        $rekap = RekapAplikasi::latest('updated_at')->first();

        return view('admin.dashboard', compact('aplikasis', 'rekap'));
    }

    public function listApk()
    {
        $opds = Opd::all();
        return view('admin.list-apk', compact('opds'));
    }

    public function showApk($id)
    {
        $apk = RekapAplikasi::with('opd')->findOrFail($id);

        $riwayatPengembangan = RekapAplikasi::where('master_rekap_aplikasi_id', $apk->master_rekap_aplikasi_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.show-apk', compact('apk', 'riwayatPengembangan'));
    }

    public function editApk()
    {
        return view('admin.edit-apk');
    }
    //
    // end

    // =========================================================
    // Bagian ini digunakan untuk 'kelola akun'
    // =========================================================
    //
    // Start
    public function editRole()
    {
        $users = User::paginate(25);;
        $opds = Opd::all();
        return view('admin.edit-role', compact('users', 'opds'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,opd,user',
            'opd_id' => 'nullable|unique:users,opd_id,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;

        if ($request->role == 'opd') {
            $user->opd_id = $request->opd_id;
            $user->status_pengajuan = 'approved';
        } else {
            $user->opd_id = null;
            $user->status_pengajuan = null;
        }

        $user->save();

        return redirect()->route('admin.edit-role')->with('success', 'Role berhasil diperbarui!');
    }
    //
    // end

    // ============================================================
    // Bagian ini untuk fungsi approve pengajuan OPD oleh user
    // ============================================================
    // Karena revisi bagian ini tidak dipakai
    // ============================================================
    //
    // Start
    public function daftarPengajuanOPD()
    {
        $pengajuans = User::where('status_pengajuan', 'pending')->with('opd')->get();
        return view('admin.pengajuan-opd', compact('pengajuans'));
    }

    public function approvePengajuan($id)
    {
        $user = User::findOrFail($id);
        $user->status_pengajuan = 'approved';
        $user->role = 'opd';
        $user->save();

        return redirect()->back()->with('success', 'Pengajuan disetujui.');
    }

    public function rejectPengajuan($id)
    {
        $user = User::findOrFail($id);
        $user->status_pengajuan = 'rejected';
        $user->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function getMasterAppDetails(Request $request)
    {
        $nama = $request->query('nama');
        $opdId = $request->query('opd_id');

        $masterApp = MasterRekapAplikasi::where('nama', $nama)
            ->where('opd_id', $opdId)
            ->first();

        if ($masterApp) {
            return response()->json($masterApp);
        }

        return response()->json(null);
    }

    public function daftarPengajuan(Request $request)
    {
        $query = RekapAplikasi::with('opd');

        // Add additional filters if needed
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Paginate the results
        $aplikasis = $query->paginate(25);

        return view('admin.daftar-pengajuan-assessment', compact('aplikasis'));
    }
    //
    // end
}
