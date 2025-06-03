<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\PenilaianFoto;
use App\Models\RekapAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penilaians = Penilaian::all();
        return view('penilaian.index', compact('penilaians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rekapAplikasiId = request('rekap_aplikasi_id');
        $rekapAplikasi = RekapAplikasi::findOrFail($rekapAplikasiId);
        return view('penilaian.create', compact('rekapAplikasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug: Cek apakah ada file yang diupload
            Log::info('Files uploaded:', $request->allFiles());

            $request->validate([
                'rekap_aplikasi_id' => 'required|exists:rekap_aplikasi,id',
                'dokumen_hasil_assessment' => 'nullable|mimes:pdf',
                'tanggal_deadline_perbaikan' => 'nullable|date',
                'keputusan_assessment' => 'nullable|in:lulus_tanpa_revisi,lulus_dengan_revisi,assessment_ulang,tidak_lulus',
                'fotos' => 'nullable|array', // Validasi array dulu
                'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $data = [
                'rekap_aplikasi_id' => $request->input('rekap_aplikasi_id'),
                'tanggal_deadline_perbaikan' => $request->input('tanggal_deadline_perbaikan'),
                'keputusan_assessment' => $request->input('keputusan_assessment'),
            ];

            // Handle dokumen hasil assessment (PDF)
            // if ($request->hasFile('dokumen_hasil_assessment')) {
            //     $pdfPath = $request->file('dokumen_hasil_assessment')->store('dokumen_assessment', 'public');
            //     $data['dokumen_hasil_assessment'] = $pdfPath;
            // }

            $penilaian = Penilaian::create($data);

            // Update rekap aplikasi status
            $rekapAplikasi = RekapAplikasi::findOrFail($request->input('rekap_aplikasi_id'));
            $this->updateRekapAplikasiStatus($rekapAplikasi, $request->input('keputusan_assessment'));

            // Handle foto dokumentasi assessment - Perbaikan di sini
            // if ($request->hasFile('fotos')) {
            //     $fotos = $request->file('fotos');

            //     foreach ($fotos as $foto) {
            //         // Cek apakah file valid sebelum disimpan
            //         if ($foto && $foto->isValid()) {
            //             try {
            //                 $path = $foto->store('penilaian_fotos', 'public');

            //                 PenilaianFoto::create([
            //                     'penilaian_id' => $penilaian->id,
            //                     'foto' => $path,
            //                 ]);

            //                 Log::info('Foto berhasil disimpan: ' . $path);
            //             } catch (\Exception $e) {
            //                 Log::error('Error menyimpan foto: ' . $e->getMessage());
            //                 // Jangan stop proses, lanjutkan ke foto berikutnya
            //             }
            //         } else {
            //             Log::warning('File foto tidak valid atau kosong');
            //         }
            //     }
            // }

            return redirect()->route('rekap-aplikasi.show', $penilaian->rekap_aplikasi_id)
                ->with('success', 'Penilaian berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing penilaian: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penilaian $penilaian)
    {
        // Load relasi yang diperlukan
        $penilaian->load(['rekapAplikasi', 'penilaianFotos']);

        return view('penilaian.show', compact('penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penilaian $penilaian)
    {
        $rekapAplikasi = RekapAplikasi::all();
        return view('penilaian.update', compact('penilaian', 'rekapAplikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        try {
            // Debug: Cek apakah ada file yang diupload
            Log::info('Files uploaded for update:', $request->allFiles());

            $request->validate([
                'rekap_aplikasi_id' => 'required|exists:rekap_aplikasi,id',
                'dokumen_hasil_assessment' => 'nullable|mimes:pdf|max:2048',
                'tanggal_deadline_perbaikan' => 'nullable|date',
                'keputusan_assessment' => 'nullable|in:lulus_tanpa_revisi,lulus_dengan_revisi,assessment_ulang,tidak_lulus',
                'fotos' => 'nullable|array', // Validasi array dulu
                'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $data = $request->only([
                'rekap_aplikasi_id',
                'tanggal_deadline_perbaikan',
                'keputusan_assessment',
            ]);

            // Handle dokumen hasil assessment (PDF)
            // if ($request->hasFile('dokumen_hasil_assessment')) {
            //     try {
            //         // Hapus file lama jika ada
            //         if ($penilaian->dokumen_hasil_assessment && Storage::exists('public/' . $penilaian->dokumen_hasil_assessment)) {
            //             Storage::delete('public/' . $penilaian->dokumen_hasil_assessment);
            //             Log::info('File PDF lama berhasil dihapus: ' . $penilaian->dokumen_hasil_assessment);
            //         }

            //         $pdfPath = $request->file('dokumen_hasil_assessment')->store('dokumen_assessment', 'public');
            //         $data['dokumen_hasil_assessment'] = $pdfPath;
            //         Log::info('File PDF baru berhasil diupload: ' . $pdfPath);
            //     } catch (\Exception $e) {
            //         Log::error('Error handling PDF file: ' . $e->getMessage());
            //         return back()->with('error', 'Gagal mengupload dokumen PDF: ' . $e->getMessage())->withInput();
            //     }
            // }

            // Update data penilaian
            $penilaian->update($data);

            // Update rekap aplikasi status
            $rekapAplikasi = RekapAplikasi::findOrFail($request->input('rekap_aplikasi_id'));
            $this->updateRekapAplikasiStatus($rekapAplikasi, $request->input('keputusan_assessment'));

            // Handle foto dokumentasi assessment - Perbaikan di sini
            // if ($request->hasFile('fotos')) {
            //     $fotos = $request->file('fotos');
            //     Log::info('Jumlah foto yang diupload: ' . count($fotos));

            //     foreach ($fotos as $index => $foto) {
            //         // Cek apakah file valid sebelum disimpan
            //         if ($foto && $foto->isValid()) {
            //             try {
            //                 $path = $foto->store('penilaian_fotos', 'public');

            //                 PenilaianFoto::create([
            //                     'penilaian_id' => $penilaian->id,
            //                     'foto' => $path,
            //                 ]);

            //                 Log::info('Foto ' . ($index + 1) . ' berhasil disimpan: ' . $path);
            //             } catch (\Exception $e) {
            //                 Log::error('Error menyimpan foto ' . ($index + 1) . ': ' . $e->getMessage());
            //                 // Jangan stop proses, lanjutkan ke foto berikutnya
            //             }
            //         } else {
            //             Log::warning('File foto ' . ($index + 1) . ' tidak valid atau kosong');
            //         }
            //     }
            // }

            return redirect()->route('rekap-aplikasi.show', $penilaian->rekap_aplikasi_id)
                ->with('success', 'Penilaian berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating penilaian: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penilaian $penilaian)
    {
        // Delete associated photos
        foreach ($penilaian->penilaianFotos as $foto) {
            Storage::delete('public/' . $foto->foto);
            $foto->delete();
        }

        $penilaian->delete();

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus.');
    }

    public function destroyFoto(PenilaianFoto $penilaianFoto)
    {
        Storage::delete('public/' . $penilaianFoto->foto);
        $penilaianFoto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    private function updateRekapAplikasiStatus(RekapAplikasi $rekapAplikasi, $keputusanAssessment)
    {
        switch ($keputusanAssessment) {
            case 'lulus_tanpa_revisi':
                $rekapAplikasi->status = 'prosesBA';
                $rekapAplikasi->jenis_jawaban = 'Diterima';
                break;
            case 'lulus_dengan_revisi':
                $rekapAplikasi->status = 'prosesBA';
                $rekapAplikasi->jenis_jawaban = null;
                break;
            case 'assessment_ulang':
                $rekapAplikasi->status = 'assessment2';
                $rekapAplikasi->jenis_jawaban = null;
                break;
            case 'tidak_lulus':
                $rekapAplikasi->status = 'batal';
                $rekapAplikasi->jenis_jawaban = 'Ditolak';
                break;
        }
        $rekapAplikasi->save();
    }
}
