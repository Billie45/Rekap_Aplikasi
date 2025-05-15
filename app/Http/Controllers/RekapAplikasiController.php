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

        $aplikasis = $query->orderBy('created_at', 'desc')->paginate(25);
        $opds = Opd::all();

        return view('./admin/list-apk', compact('aplikasis', 'opds'));
    }
    //
    // end

    public function show($id)
    {
        $apk = \App\Models\RekapAplikasi::with(['opd', 'undangan'])->findOrFail($id);
        $opds = Opd::all();
        return view('admin.show-apk', compact('apk', 'opds'));
    }

    // =======================================================================
    // Digunakan untuk 'ajukan assessment' di 'opd/form-pengajuan-assessment'
    // =======================================================================
    //
    // Start
    public function indexAssessment()
    {
        $aplikasis = RekapAplikasi::with('opd')->get();
        $opds = Opd::all();
        $rekap = RekapAplikasi::latest('updated_at')->first();

        return view('./opd/dashboard', compact('aplikasis', 'opds', 'rekap'));
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
            'permohonan' => 'required|date',
        ], [
            'nama.required' => 'Nama aplikasi wajib diisi.',
            'opd_id.required' => 'OPD wajib dipilih.',
            'tipe.required' => 'Tipe aplikasi wajib diisi.',
            'jenis.required' => 'Jenis aplikasi wajib diisi.',
            'status.required' => 'Status aplikasi wajib diisi.',
            'permohonan.required' => 'Tanggal permohonan wajib diisi.',
            'permohonan.date' => 'Tanggal permohonan harus berformat tanggal yang valid.',
        ]);

         $validated['assesment_terakhir'] = $request->assesment_terakhir ?? ($apk->updated_at ?? now())->format('Y-m-d');

        // Create new application record with all form fields
        RekapAplikasi::create([
            // Informasi Umum
            'permohonan' => $request->input('permohonan'),
            'opd_id' => $request->input('opd_id'),
            'nama' => $request->input('nama'),
            'subdomain' => $request->input('subdomain'),
            'tipe' => $request->input('tipe'),
            'jenis' => $request->input('jenis'),
            'status' => $request->input('status'),
            'keterangan' => $request->input('keterangan'),
            'last_update' => $request->input('last_update'),
            'jenis_permohonan' => $request->input('jenis_permohonan'),
            'tanggal_masuk_ba' => $request->input('tanggal_masuk_ba'),
            'link_dokumentasi' => $request->input('link_dokumentasi'),

            // Informasi Akun
            'akun_link' => $request->input('akun_link'),
            'akun_username' => $request->input('akun_username'),
            'akun_password' => $request->input('akun_password'),

            // Contact Person OPD
            'cp_opd_nama' => $request->input('cp_opd_nama'),
            'cp_opd_no_telepon' => $request->input('cp_opd_no_telepon'),

            // Contact Person Pengembang
            'cp_pengembang_nama' => $request->input('cp_pengembang_nama'),
            'cp_pengembang_no_telepon' => $request->input('cp_pengembang_no_telepon'),

            // Rekap Laporan Progres
            'assesment_terakhir' => $request->input('assesment_terakhir'),
            'undangan_terakhir' => $request->input('undangan_terakhir'),
            'laporan_perbaikan' => $request->input('laporan_perbaikan'),

            // Detail Akses Server
            'server' => $request->input('server'), // Using input() here to avoid ServerBag object
            'status_server' => $request->input('status_server'),
            'open_akses' => $request->input('open_akses'),
            'close_akses' => $request->input('close_akses'),
            'urgensi' => $request->input('urgensi'),
        ]);

        return redirect()->route('rekap-aplikasi.index')
            ->with('success', 'Aplikasi berhasil ditambahkan.');
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
            'jenis_assessment' => 'Pertama',
            'jenis_jawaban' => null,
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

        return redirect()->route('opd.daftar-pengajuan-assessment');
    }
    //
    // end

    // ======================================================================
    // Fungsi untuk verifikasi pengajuan assessment oleh admin
    // ======================================================================
    //
    // Start
    public function terima($id) {
        $item = RekapAplikasi::findOrFail($id);
        $item->status = 'assessment1';
        $item->jenis_jawaban = 'Diterima';
        $item->save();

        // Determine redirect route based on user role
        $redirectRoute = Auth::user()->role == 'admin'
            ? 'opd.daftar-pengajuan-assessment'
            : 'opd.daftar-pengajuan-assessment';

        return redirect()->route($redirectRoute)->with('success', 'Assessment telah diterima');
    }

    public function revisi_tombol($id) {
        $item = RekapAplikasi::findOrFail($id);
        $item->status = 'perbaikan';
        $item->jenis_jawaban = 'Ditolak';
        $item->save();

        // Determine redirect route based on user role
        $redirectRoute = Auth::user()->role == 'admin'
            ? 'opd.daftar-pengajuan-assessment'
            : 'opd.daftar-pengajuan-assessment';

        return redirect()->route($redirectRoute)->with('success', 'Assessment diminta revisi');
    }

    public function tolak($id) {
        $item = RekapAplikasi::findOrFail($id);
        $item->status = 'batal';
        $item->jenis_jawaban = 'Ditolak';
        $item->save();

        // Determine redirect route based on user role
        $redirectRoute = Auth::user()->role == 'admin'
            ? 'opd.daftar-pengajuan-assessment'
            : 'opd.daftar-pengajuan-assessment';

        return redirect()->route($redirectRoute)->with('success', 'Assessment telah ditolak');
    }

    public function showRevisiForm($id) {
        $item = RekapAplikasi::with('opd')->findOrFail($id);

        $user = Auth::user();

        $opd = $user->opd;

        return view('opd.form-revisi-assessment', [
            'apk' => $item,
            'namaOpd' => $opd?->nama_opd ?? '',
        ]);
    }

    public function submitRevisi(Request $request, $id) {

        $validated = $request->validate([
            'nama' => 'required',
            'opd_id' => 'required',
            'subdomain' => 'nullable',
            'tipe' => 'required',
            'last_update' => 'nullable',
            'jenis_permohonan' => 'required',
            'permohonan' => 'required|date',
            'link_dokumentasi' => 'nullable|url',
            'akun_link' => 'nullable|url',
            'akun_username' => 'nullable',
            'akun_password' => 'nullable',
            'cp_opd_nama' => 'nullable',
            'cp_opd_no_telepon' => 'nullable',
            'cp_pengembang_nama' => 'nullable',
            'cp_pengembang_no_telepon' => 'nullable',
        ]);

        $item = RekapAplikasi::findOrFail($id);

        $item->update($validated);
        $item->status = 'perbaikan';
        $item->jenis_assessment = 'Revisi';
        $item->jenis_jawaban = null;
        $item->save();

        return redirect()->route('opd.daftar-pengajuan-assessment')->with('success', 'Revisi telah diajukan');
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
