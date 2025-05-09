<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapAplikasi;

use App\Models\User;
use App\Models\Opd;

class AdminController extends Controller
{
    public function dashboard()
    {
        $aplikasis = RekapAplikasi::all();
        return view('admin.dashboard', compact('aplikasis'));
    }

    public function listApk()
    {
        $opds = Opd::all();
        return view('admin.list-apk', compact('opds'));
    }

    public function editApk()
    {
        return view('admin.edit-apk');
    }

    public function editRole()
    {
        $users = User::paginate(20);;
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

    // Bagian ini untuk fungsi approve pengajuan OPD oelh user
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
    // end
}
