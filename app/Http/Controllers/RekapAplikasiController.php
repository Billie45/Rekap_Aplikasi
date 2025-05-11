<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapAplikasi;
use App\Models\Opd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RekapAplikasiController extends Controller
{
    // ============================================================
    // Digunakan untuk 'tambah' di halaman 'admin/list-apk'
    // ============================================================
    //
    // Start
    public function index(Request $request)
    {
        $query = RekapAplikasi::with('opd');

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('server')) {
            $query->where('server', 'like', '%' . $request->input('server') . '%');
        }

        $aplikasis = $query->orderBy('created_at', 'desc')->paginate(15);
        $opds = Opd::all();

        return view('./admin/list-apk', compact('aplikasis', 'opds'));
    }
    //
    // end

    // =======================================================================
    // Digunakan untuk 'ajukan assessment' di 'opd/form-pengajuan-assessment'
    // =======================================================================
    //
    // Start
    public function indexAssessment()
    {
        $aplikasis = RekapAplikasi::with('opd')->get();
        $opds = Opd::all();

        return view('./opd/dashboard', compact('aplikasis', 'opds'));
    }

    public function createAssessment()
    {
        $user = Auth::user();
        if (!$user || !$user->opd) {
            abort(403, 'You must be associated with an OPD to submit this form.');
        }
        $opd = $user->opd;

        return view('opd.form-assessment', [
            'opdId' => $opd?->id,
            'namaOpd' => $opd?->nama_opd ?? '',
        ]);

    }
    //
    // end

    // ============================================================
    // Digunakan untuk 'tambah' di halaman 'admin/list-apk'
    // ============================================================
    //
    // Start
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'opd_id' => 'required',
            'tipe' => 'required',
            'jenis' => 'required',
            'status' => 'required',
        ], [
            'nama.required' => 'Nama aplikasi wajib diisi.',
            'opd_id.required' => 'OPD wajib dipilih.',
            'tipe.required' => 'Tipe aplikasi wajib diisi.',
            'jenis.required' => 'Jenis aplikasi wajib diisi.',
            'status.required' => 'Status aplikasi wajib diisi.',
        ]);

        RekapAplikasi::create([
            'nama' => $request->nama,
            'opd_id' => $request->opd_id,
            'tipe' => $request->tipe,
            'jenis' => $request->jenis,
            'status' => $request->status,
        ]);

        return redirect()->route('rekap-aplikasi.index')->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    public function create()
    {
        $apk = new RekapAplikasi();
        $opds = Opd::all();
        return view('nama_view', compact('apk', 'opds'));
    }
    //
    // end

    // ======================================================================
    // Digunakan untuk 'ajukan assessment' di 'opd/form-pengajuan-assessment'
    // ======================================================================
    //
    // Start
    public function storeAssessment(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'opd_id' => 'required',
            'subdomain' => 'nullable',
            'tipe' => 'nullable',
            'jenis' => 'nullable',
            'status' => 'nullable',
            // 'server' => 'nullable',
            // 'keterangan' => 'nullable',
            // 'last_update' => 'nullable',
            'jenis_permohonan' => 'nullable',
            'tanggal_masuk_ba' => 'nullable',
            'link_dokumentasi' => 'nullable',
            'akun_link' => 'nullable',
            'akun_username' => 'nullable',
            'akun_password' => 'nullable',
            'cp_opd_nama' => 'nullable',
            'cp_opd_no_telepon' => 'nullable',
            'cp_pengembang_nama' => 'nullable',
            'cp_pengembang_no_telepon' => 'nullable',
            // 'assesment_terakhir' => 'nullable',
            'permohonan' => 'nullable',
            'undangan_terakhir' => 'nullable',
            'laporan_perbaikan' => 'nullable',
            // 'open_akses' => 'nullable',
            // 'close_akses' => 'nullable',
            // 'urgensi' => 'nullable',
        ]);

        RekapAplikasi::create([
            'nama' => $request->nama,
            'opd_id' => $request->opd_id,
            'subdomain' => $request->subdomain,
            'tipe' => $request->tipe,
            'jenis' => 'baru',
            'status' => 'diproses',
            // 'server' => '',
            // 'keterangan' => '-',
            // 'last_update' => '-',
            'jenis_permohonan' => $request->jenis_permohonan,
            'tanggal_masuk_ba' => $request->tanggal_masuk_ba,
            'link_dokumentasi' => $request->link_dokumentasi,
            'akun_link' => $request->akun_link,
            'akun_username' => $request->akun_username,
            'akun_password' => $request->akun_password,
            'cp_opd_nama' => $request->cp_opd_nama,
            'cp_opd_no_telepon' => $request->cp_opd_no_telepon,
            'cp_pengembang_nama' => $request->cp_pengembang_nama,
            'cp_pengembang_no_telepon' => $request->cp_pengembang_no_telepon,
            //'assesment_terakhir' => '-',
            'permohonan' => $request->permohonan,
            'undangan_terakhir' => $request->undangan_terakhir,
            'laporan_perbaikan' => $request->laporan_perbaikan,
            // 'open_akses' => '-',
            // 'close_akses' => '-',
            // 'urgensi' => '-',
        ]);

        return redirect()->route('rekap-aplikasi.indexAssessment');
    }
    //
    // end

    // ======================================================================
    // Fungsi digunakan untuk admin melakukan edit assessment
    // ======================================================================
    //
    // Start
    public function edit($id)
    {
        $apk = RekapAplikasi::with('opd')->findOrFail($id);
        $opds = Opd::all();

        return view('admin.edit-apk', compact('apk', 'opds'));
    }


    public function update(Request $request, $id)
    {
        $apk = RekapAplikasi::findOrFail($id);

        $messages = [
            'link_dokumentasi.url' => 'Format URL tidak valid.',
            'akun_link.url' => 'Format URL tidak valid.',
        ];

        try {
            $validated = $request->validate([
                'nama' => 'nullable|string|max:255',
                'opd_id' => 'nullable|exists:opds,id',
                'subdomain' => 'nullable|string|max:255',
                'tipe' => 'nullable|string|max:255',
                'jenis' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
                'server' => 'nullable|string|max:255',
                'keterangan' => 'nullable|string',
                'last_update' => 'nullable|string',
                'jenis_permohonan' => 'nullable|string|max:255',
                'tanggal_masuk_ba' => 'nullable|date',
                'link_dokumentasi' => 'nullable|string|max:255',
                'akun_link' => 'nullable|string|max:255',
                'akun_username' => 'nullable|string|max:255',
                'akun_password' => 'nullable|string|max:255',
                'cp_opd_nama' => 'nullable|string|max:255',
                'cp_opd_no_telepon' => 'nullable|string|max:20',
                'cp_pengembang_nama' => 'nullable|string|max:255',
                'cp_pengembang_no_telepon' => 'nullable|string|max:20',
                'assesment_terakhir' => 'nullable|date',
                'permohonan' => 'nullable|date',
                'undangan_terakhir' => 'nullable|date',
                'laporan_perbaikan' => 'nullable|date',
                'status_server' => 'nullable|string|max:255',
                'open_akses' => 'nullable|date',
                'close_akses' => 'nullable|date',
                'urgensi' => 'nullable|string|max:255',
            ], $messages);

            $updateData = [];
            foreach ($validated as $key => $value) {
                $updateData[$key] = ($value === '') ? null : $value;
            }

            $apk->update($updateData);

            return redirect()->route('rekap-aplikasi.index')
                ->with('success', 'Data aplikasi berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation errors for debugging
            Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Update error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. ' . $e->getMessage())
                ->withInput();
        }
    }
    //
    // end

    // ============================================================
    // Mulai ke bawah ini mencoba melakukan soft delete
    // ============================================================
    // hanya 'public function destroy($id)' yang dipakai
    // ============================================================
    //
    // start
    public function destroy($id)
    {
        $apk = RekapAplikasi::findOrFail($id);
        $apk-> delete();

        return redirect()->route('rekap-aplikasi.index')->with('success', 'Aplikasi berhasil dihapus (disembunyikan).');
    }

     /**
     * Display a list of soft-deleted records
     */
    public function trash()
    {
        $trashedAplikasis = RekapAplikasi::onlyTrashed()->with('opd')->get();

        return view('admin.trash-apk', compact('trashedAplikasis'));
    }

    /**
     * Restore a soft-deleted record
     */
    public function restore($id)
    {
        $apk = RekapAplikasi::onlyTrashed()->findOrFail($id);
        $apk->restore();

        return redirect()->route('rekap-aplikasi.trash')
            ->with('success', 'Aplikasi berhasil dipulihkan.');
    }

    /**
     * Permanently delete a record
     */
    public function forceDelete($id)
    {
        // Find the soft-deleted record
        $apk = RekapAplikasi::onlyTrashed()->findOrFail($id);
        $apk->forceDelete();

        return redirect()->route('rekap-aplikasi.trash')
            ->with('success', 'Aplikasi berhasil dihapus secara permanen.');
    }
    //
    //end
}
