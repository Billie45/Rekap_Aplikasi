<?php

namespace App\Http\Controllers;

use App\Models\MasterRekapAplikasi;
use App\Models\RiwayatRevisiAssessment;
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
    // Sebagai admin, kita bisa melakukan filtering data
    // berdasarkan nama, opd_id, tipe, jenis, status, dan server
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

    // ============================================================
    // Digunakan untuk melihat undangan pada rekap aplikasi (admin/show-apk)
    // ============================================================
    //
    // Start
    public function show($id)
    {
        $apk = \App\Models\RekapAplikasi::with(['opd', 'undangan'])->findOrFail($id);
        $opds = Opd::all();
        return view('admin.show-apk', compact('apk', 'opds'));
    }
    //
    // end

// ============================================================
    // Digunakan untuk create rekap aplikasi untuk admin di halaman 'admin/list-apk'
    // ============================================================
    // Ini adalah controller untuk Admin
    // =======================================================================
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

        // 1) Get the name and OPD ID
        $nama = $request->nama;
        $opdId = $request->opd_id;

        // 2) Handle master record
        $master = MasterRekapAplikasi::firstOrNew([
            'opd_id' => $opdId,
            'nama'   => $nama,
        ]);

        // 3) Copy across all the master-level fields
        $master->fill([
            'tipe' => $request->tipe,
            'jenis' => $request->jenis,
            'jenis_permohonan' => $request->jenis_permohonan,
            'subdomain' => $request->subdomain,
            'akun_link' => $request->akun_link,
            'akun_username' => $request->akun_username,
            'akun_password' => $request->akun_password,
        ]);

        $master->updated_at = now();
        if (!$master->exists) {
           $master->created_at = now();
        }

        $master->save();

        // 2. Create rekap_aplikasi record with all form fields and link to master
        RekapAplikasi::create([
            // Informasi Umum
            'permohonan' => $request->input('permohonan'),
            'opd_id' => $opdId,
            'nama' => $nama,
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
            'assesment_terakhir' => $request->input('assesment_terakhir') ?? now()->format('Y-m-d'),
            'undangan_terakhir' => $request->input('undangan_terakhir'),
            'laporan_perbaikan' => $request->input('laporan_perbaikan'),

            // Detail Akses Server
            'server' => $request->input('server'),
            'status_server' => $request->input('status_server'),
            'open_akses' => $request->input('open_akses'),
            'close_akses' => $request->input('close_akses'),
            'urgensi' => $request->input('urgensi'),

            // Link to master record
            'master_rekap_aplikasi_id' => $master->id,
        ]);

        return redirect()->route('rekap-aplikasi.index')
            ->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    public function create()
    {
        $apk = new RekapAplikasi();
        $opds = Opd::all();
        $masters = MasterRekapAplikasi::all();

        return view('nama_view', compact('apk', 'opds', 'apps'));
    }
    //
    // end

    // ======================================================================
    // Fungsi digunakan untuk admin melakukan edit assessment
    // ======================================================================
    // Ini adalah controller untuk Admin
    // =======================================================================
    //
    // Start
    public function edit($id)
    {
        $apk = RekapAplikasi::with('opd')->findOrFail($id);
        $opds = Opd::all();
        $opd_id = $apk->opd_id;

        // Get master apps for the OPD for the dropdown
        $apps = \App\Models\MasterRekapAplikasi::where('opd_id', $opd_id)
            ->where('jenis', 'baru')
            ->get();

        return view('admin.edit-apk', compact('apk', 'opds', 'opd_id', 'apps'));
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

            // 1) Get the name and OPD ID
            $nama = $request->nama;
            $opdId = $request->opd_id;

            // 2) Handle master record
            $master = MasterRekapAplikasi::firstOrNew([
                'opd_id' => $opdId,
                'nama'   => $nama,
            ]);

            // 3) Copy across all the master-level fields
            $master->fill([
                'tipe' => $request->tipe,
                'jenis' => $request->jenis,
                'jenis_permohonan' => $request->jenis_permohonan,
                'subdomain' => $request->subdomain,
                'akun_link' => $request->akun_link,
                'akun_username' => $request->akun_username,
                'akun_password' => $request->akun_password,
            ]);

            $master->updated_at = now();
            if (!$master->exists) {
                $master->created_at = now();
            }

            $master->save();

            // 4) Update the RekapAplikasi with master ID
            $updateData = [];
            foreach ($validated as $key => $value) {
                $updateData[$key] = ($value === '') ? null : $value;
            }

            // Add master ID to the update data
            $updateData['master_rekap_aplikasi_id'] = $master->id;

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

    // ======================================================================
    // Fungsi untuk mendapatkan data master aplikasi berdasarkan OPD
    // ======================================================================
    //
    // Start
    public function getMasterApps($opdId)
    {
        $masterApps = \App\Models\MasterRekapAplikasi::where('opd_id', $opdId)->get();
        return response()->json($masterApps);
    }

    public function getMasterAppDetails(Request $request)
    {
        $app = MasterRekapAplikasi::where('opd_id', $request->opd_id)
                                ->where('nama', $request->nama)
                                ->first();

        if (!$app) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'jenis' => $app->jenis,
            'tipe' => $app->tipe,
            'jenis_permohonan' => $app->jenis_permohonan,
            'subdomain' => $app->subdomain,
            'akun_link' => $app->akun_link,
            'akun_username' => $app->akun_username,
            'akun_password' => $app->akun_password,
        ]);
    }
    //
    // end


    // =======================================================================
    // Digunakan untuk 'ajukan assessment' di 'opd/form-pengajuan-assessment'
    // =======================================================================
    // Ini adalah controller untuk OPD
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

    // ======================================================================
    // Digunakan untuk 'ajukan assessment' di 'opd/form-pengajuan-assessment'
    // ======================================================================
    // Ini adalah controller untuk OPD
    // =======================================================================
    //
    // Start
    public function formAssessment()
    {
        $opd_id = auth::user()->opd_id;

        // Ambil aplikasi yang sudah ada dengan opd_id dan jenis 'baru' (misal)
        $apps = \App\Models\MasterRekapAplikasi::where('opd_id', $opd_id)
            ->where('jenis', 'baru')
            ->get();

        return view('opd.form-pengajuan-assessment', compact('apps'));
    }

    public function storeAssessment(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'opd_id' => 'required',
            'subdomain' => 'nullable',
            'tipe' => 'nullable',
            'jenis' => 'nullable',
            'status' => 'nullable',
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
            'permohonan' => 'nullable',
            'undangan_terakhir' => 'nullable',
            'laporan_perbaikan' => 'nullable',
            'surat_permohonan' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Validasi file
        ]);

        $opdId = auth::user()->opd_id;

        // Cek jika jenis pengembangan adalah "baru"
        if ($request->jenis === 'baru') {
            $existing = RekapAplikasi::where('nama', $request->nama)
                        ->where('opd_id', $opdId)
                        ->exists();

            if ($existing) {
                return back()->withErrors(['nama' => 'Nama aplikasi sudah terdaftar oleh instansi Anda.'])->withInput();
            }
        }

        $nama = $request->nama;
        $opdId = $request->opd_id;

        $master = MasterRekapAplikasi::firstOrNew([
            'opd_id' => $opdId, 'nama' => $nama
        ]);

        $master->fill([
                'tipe' => $request->tipe,
                'jenis' => $request->jenis,
                'jenis_permohonan' => $request->jenis_permohonan,
                'subdomain' => $request->subdomain,
                'akun_link' => $request->akun_link,
                'akun_username' => $request->akun_username,
                'akun_password' => $request->akun_password,
        ]);

        $master->updated_at = now();
            if (!$master->exists) {
                $master->created_at = now();
            }

        $master->save();

        $rekapAplikasi = RekapAplikasi::create([
            'nama' => $request->nama,
            'opd_id' => $request->opd_id,
            'subdomain' => $request->subdomain,
            'tipe' => $request->tipe,
            'jenis' => $request->jenis,
            'status' => 'diproses',
            'jenis_assessment' => 'Pertama',
            'jenis_jawaban' => null,
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
            'permohonan' => $request->permohonan,
            'undangan_terakhir' => $request->undangan_terakhir,
            'laporan_perbaikan' => $request->laporan_perbaikan,
            'master_rekap_aplikasi_id' => $master->id,
        ]);

        // Handle file upload
        if ($request->hasFile('surat_permohonan')) {
            $file = $request->file('surat_permohonan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('surat_permohonan'), $fileName); // Simpan di folder public/surat_permohonan
            $suratPermohonanPath = 'surat_permohonan/' . $fileName; // Simpan path ke database
        } else {
            $suratPermohonanPath = null;
        }

        RiwayatRevisiAssessment::create([
            'rekap_aplikasi_id' => $rekapAplikasi->id,
            'permohonan' => $request->permohonan,
            'opd_id' => $request->opd_id,
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'subdomain' => $request->subdomain,
            'tipe' => $request->tipe,
            'jenis_permohonan' => $request->jenis_permohonan,
            'link_dokumentasi' => $request->link_dokumentasi,
            'akun_link' => $request->akun_link,
            'akun_username' => $request->akun_username,
            'akun_password' => $request->akun_password,
            'cp_opd_nama' => $request->cp_opd_nama,
            'cp_opd_no_telepon' => $request->cp_opd_no_telepon,
            'cp_pengembang_nama' => $request->cp_pengembang_nama,
            'cp_pengembang_no_telepon' => $request->cp_pengembang_no_telepon,
            'surat_permohonan' => $suratPermohonanPath, // Simpan path file
        ]);

        return redirect()->route('opd.daftar-pengajuan-assessment');
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
            'surat_permohonan' => 'nullable|files|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $item = RekapAplikasi::findOrFail($id);

        $item->update($validated);
        $item->status = 'perbaikan';
        $item->jenis_assessment = 'Revisi';
        $item->jenis_jawaban = null;
        $item->save();

        // Handle file upload
        if ($request->hasFile('surat_permohonan')) {
            $file = $request->file('surat_permohonan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('surat_permohonan'), $fileName); // Simpan di folder public/surat_permohonan
            $suratPermohonanPath = 'surat_permohonan/' . $fileName; // Simpan path ke database
        } else {
            $suratPermohonanPath = null;
        }

        RiwayatRevisiAssessment::create([
            'rekap_aplikasi_id' => $item->id,
            'permohonan' => $request->permohonan,
            'opd_id' => $request->opd_id,
            'jenis' => $item->jenis,
            'nama' => $request->nama,
            'subdomain' => $request->subdomain,
            'tipe' => $request->tipe,
            'jenis_permohonan' => $request->jenis_permohonan,
            'link_dokumentasi' => $request->link_dokumentasi,
            'akun_link' => $request->akun_link,
            'akun_username' => $request->akun_username,
            'akun_password' => $request->akun_password,
            'cp_opd_nama' => $request->cp_opd_nama,
            'cp_opd_no_telepon' => $request->cp_opd_no_telepon,
            'cp_pengembang_nama' => $request->cp_pengembang_nama,
            'cp_pengembang_no_telepon' => $request->cp_pengembang_no_telepon,
            'surat_permohonan' => $suratPermohonanPath, // Simpan path file
        ]);

        return redirect()->route('opd.daftar-pengajuan-assessment')->with('success', 'Revisi telah diajukan');
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

        // Redirect sesuai role
        $redirectRoute = Auth::user()->role == 'admin'
            ? 'admin.daftar-pengajuan-assessment'
            : 'opd.daftar-pengajuan-assessment';

        return redirect()->route($redirectRoute)->with('success', 'Assessment telah diterima');
    }

    public function revisi_tombol($id) {
        $item = RekapAplikasi::findOrFail($id);
        $item->status = 'perbaikan';
        $item->jenis_jawaban = 'Ditolak';
        $item->save();

        // Redirect sesuai role
        $redirectRoute = Auth::user()->role == 'admin'
            ? 'admin.daftar-pengajuan-assessment'
            : 'opd.daftar-pengajuan-assessment';

        return redirect()->route($redirectRoute)->with('success', 'Assessment diminta revisi');
    }

    public function tolak($id) {
        $item = RekapAplikasi::findOrFail($id);
        $item->status = 'batal';
        $item->jenis_jawaban = 'Ditolak';
        $item->save();

        // Redirect sesuai role
        $redirectRoute = Auth::user()->role == 'admin'
            ? 'admin.daftar-pengajuan-assessment'
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
