<?php

namespace App\Http\Controllers;

use App\Models\Undangan;
use App\Models\RekapAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UndanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $apk_id = $request->apk_id;
        $apk = RekapAplikasi::findOrFail($apk_id);

        return view('undangan.create', compact('apk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rekap_aplikasi_id' => 'required|exists:rekap_aplikasi,id',
            'tanggal_undangan' => 'required|date',
            'assessment_dokumentasi' => 'nullable|file|mimes:pdf,doc,docx',
            'catatan_assessment' => 'nullable|string',
            'surat_rekomendasi' => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        if ($request->hasFile('assessment_dokumentasi')) {
            $validated['assessment_dokumentasi'] = $request->file('assessment_dokumentasi')
                ->store('undangan/assessment', 'public');
        }

        if ($request->hasFile('surat_rekomendasi')) {
            $validated['surat_rekomendasi'] = $request->file('surat_rekomendasi')
                ->store('undangan/rekomendasi', 'public');
        }

        Undangan::create($validated);

        // Update kolom `undangan_terakhir` di tabel rekap_aplikasi
        $rekap = RekapAplikasi::find($validated['rekap_aplikasi_id']);
        $rekap->undangan_terakhir = $rekap->undangan()->latest('tanggal_undangan')->value('tanggal_undangan');
        $rekap->save();

        return redirect()->route('rekap-aplikasi.show', $validated['rekap_aplikasi_id'])
            ->with('success', 'Undangan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Undangan $undangan)
    {
        $apk = $undangan->rekapAplikasi;
        return view('undangan.edit', compact('undangan', 'apk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Undangan $undangan)
    {
        $validated = $request->validate([
            'tanggal_undangan' => 'required|date',
            'assessment_dokumentasi' => 'nullable|file|mimes:pdf,doc,docx',
            'catatan_assessment' => 'nullable|string',
            'surat_rekomendasi' => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        if ($request->hasFile('assessment_dokumentasi')) {
            if ($undangan->assessment_dokumentasi) {
                Storage::disk('public')->delete($undangan->assessment_dokumentasi);
            }
            $validated['assessment_dokumentasi'] = $request->file('assessment_dokumentasi')
                ->store('undangan/assessment', 'public');
        }

        if ($request->hasFile('surat_rekomendasi')) {
            if ($undangan->surat_rekomendasi) {
                Storage::disk('public')->delete($undangan->surat_rekomendasi);
            }
            $validated['surat_rekomendasi'] = $request->file('surat_rekomendasi')
                ->store('undangan/rekomendasi', 'public');
        }

        $undangan->update($validated);

        return redirect()->route('rekap-aplikasi.show', $undangan->rekap_aplikasi_id)
            ->with('success', 'Undangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Undangan $undangan)
    {
        $apk_id = $undangan->rekap_aplikasi_id;

        if ($undangan->assessment_dokumentasi) {
            Storage::disk('public')->delete($undangan->assessment_dokumentasi);
        }

        if ($undangan->surat_rekomendasi) {
            Storage::disk('public')->delete($undangan->surat_rekomendasi);
        }

        $undangan->delete();

        return redirect()->route('rekap-aplikasi.show', $apk_id)
            ->with('success', 'Undangan berhasil dihapus!');
    }
}
