<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\RevisiPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RevisiPenilaianController extends Controller
{
    /**
     * Display a listing of revisions for a penilaian
     */
    public function index(Penilaian $penilaian)
    {
        $revisiPenilaians = $penilaian->revisiPenilaians()->latest()->get();
        return view('revisi-penilaian.index', compact('penilaian', 'revisiPenilaians'));
    }

    /**
     * Show the form for creating a new revision
     */
    public function create(Penilaian $penilaian)
    {
        return view('revisi-penilaian.create', compact('penilaian'));
    }

    /**
     * Store a newly created revision
     */
    public function store(Request $request, Penilaian $penilaian)
    {
        try {
            // Add debug logging
            Log::info('Received form data:', $request->all());

            $validated = $request->validate([
                'catatan_revisi' => 'required|string',
                // Untuk Local
                // 'dokumen_revisi' => 'required|file|mimes:pdf',
                // 'dokumen_laporan' => 'required|file|mimes:pdf'

                // Untuk Hosting Gratis
                'dokumen_revisi' => 'nullable|file|mimes:pdf',
                'dokumen_laporan' => 'nullable|file|mimes:pdf'
            ]);

            // Add more debug logging
            Log::info('Validated data:', $validated);

            if ($request->hasFile('dokumen_revisi')) {
                $path = $request->file('dokumen_revisi')->store('revisi-documents', 'public');
                $validated['dokumen_revisi'] = $path;
            }

            if ($request->hasFile('dokumen_laporan')) {
                $path = $request->file('dokumen_laporan')->store('laporan-documents', 'public');
                $validated['dokumen_laporan'] = $path;
            }

            $validated['penilaian_id'] = $penilaian->id;
            $validated['status'] = 'diajukan';

            // Add debug logging
            Log::info('Final data to save:', $validated);

            $revisiPenilaian = RevisiPenilaian::create($validated);

            // Update status penilaian
            $penilaian->rekapAplikasi->update([
                'jenis_jawaban' => 'Diproses'
            ]);

            return redirect()
                ->route('penilaian.show', $penilaian->id)
                ->with('success', 'Pengajuan revisi berhasil dibuat');

        } catch (\Exception $e) {
            Log::error('Error creating revision: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat membuat revisi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified revision
     */
    public function show(RevisiPenilaian $revisiPenilaian)
    {
        $revisiPenilaian->load('penilaian.rekapAplikasi');
        return view('revisi-penilaian.show', compact('revisiPenilaian'));
    }

    /**
     * Show the form for editing the specified revision
     */
    public function edit(Penilaian $penilaian, RevisiPenilaian $revisi_penilaian)
    {
        return view('revisi-penilaian.update', [
            'penilaian' => $penilaian,
            'revisiPenilaian' => $revisi_penilaian
        ]);
    }

    /**
     * Update the specified revision
     */
    public function update(Request $request, Penilaian $penilaian, RevisiPenilaian $revisi_penilaian)
    {
        try {
            $validated = $request->validate([
                'catatan_revisi' => 'nullable|string',
                // Untuk Local
                // 'dokumen_revisi' => 'required|file|mimes:pdf',
                // 'dokumen_laporan' => 'required|file|mimes:pdf',

                // Untuk Hosting Gratis
                'dokumen_revisi' => 'nullable|file|mimes:pdf',
                'dokumen_laporan' => 'nullable|file|mimes:pdf',
                'status' => 'nullable|in:diajukan,diproses,selesai'
            ]);

            if ($request->hasFile('dokumen_revisi')) {
                if ($revisi_penilaian->dokumen_revisi) {
                    Storage::disk('public')->delete($revisi_penilaian->dokumen_revisi);
                }
                $path = $request->file('dokumen_revisi')->store('revisi-documents', 'public');
                $validated['dokumen_revisi'] = $path;
            }

            if ($request->hasFile('dokumen_laporan')) {
                if ($revisi_penilaian->dokumen_laporan) {
                    Storage::disk('public')->delete($revisi_penilaian->dokumen_laporan);
                }
                $path = $request->file('dokumen_laporan')->store('laporan-documents', 'public');
                $validated['dokumen_laporan'] = $path;
            }

            $revisi_penilaian->update($validated);

            // Update status penilaian if revision is completed
            $penilaian->rekapAplikasi->update([
                'status' => 'prosesBA',
                'jenis_jawaban' => 'Diproses'
            ]);

            return redirect()
                ->route('penilaian.show', [
                    'penilaian' => $penilaian->id,
                    'revisi_penilaian' => $revisi_penilaian->id
                ])
                ->with('success', 'Revisi berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error updating revision: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui revisi')
                ->withInput();
        }
    }

    /**
     * Remove the specified revision
     */
    public function destroy(RevisiPenilaian $revisiPenilaian)
    {
        try {
            // Delete associated files if they exist
            if ($revisiPenilaian->dokumen_revisi) {
                Storage::disk('public')->delete($revisiPenilaian->dokumen_revisi);
            }
            if ($revisiPenilaian->dokumen_laporan) {
                Storage::disk('public')->delete($revisiPenilaian->dokumen_laporan);
            }

            $revisiPenilaian->delete();

            return redirect()
                ->route('penilaian.show', $revisiPenilaian->penilaian_id)
                ->with('success', 'Revisi berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Error deleting revision: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus revisi');
        }
    }

    /**
     * Process the verdict for a revision
     */
    public function verdict(Request $request, Penilaian $penilaian)
    {
        try {
            $verdict = $request->verdict;
            $revisiPenilaian = $penilaian->revisiPenilaians()->latest()->first();

            if ($verdict === 'terima') {
                // Update RekapAplikasi status
                $penilaian->rekapAplikasi->update([
                    'jenis_jawaban' => 'Diterima'
                ]);

                // Update RevisiPenilaian status
                $revisiPenilaian->update([
                    'status' => 'selesai'
                ]);

                $message = 'Revisi penilaian berhasil diterima';
            } else {
                // Update RekapAplikasi status
                $penilaian->rekapAplikasi->update([
                    'jenis_jawaban' => 'Ditolak'
                ]);

                // Update RevisiPenilaian status
                $revisiPenilaian->update([
                    'status' => 'diproses'
                ]);

                $message = 'Revisi penilaian ditolak';
            }

            return redirect()
                ->route('penilaian.show', $penilaian->id)
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error processing revision verdict: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses keputusan revisi');
        }
    }
}
