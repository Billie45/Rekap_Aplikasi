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

        // Untuk menghindari duplikasi undangan
        if ($apk->penilaian()->exists()) {
            $apk->status = 'assessment2';
        } else {
            $apk->status = 'assessment1';
        }
        $apk->jenis_jawaban = 'Diterima';
        $apk->save();

        return view('undangan.create', compact('apk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rekap_aplikasi_id' => 'required|exists:rekap_aplikasi,id',
            'tanggal_assessment' => 'required|date',
            'surat_undangan' => 'nullable|file|mimes:pdf,doc,docx',
            'link_zoom_meeting' => 'nullable|string',
            'tanggal_zoom_meeting' => 'nullable|date',
            'waktu_zoom_meeting' => 'nullable|string',
            'tempat' => 'nullable|string',
        ]);

        if ($request->hasFile('surat_undangan')) {
            $validated['surat_undangan'] = $request->file('surat_undangan')
                ->store('undangan/surat', 'public');
        }

        Undangan::create($validated);

        // Update kolom `undangan_terakhir` di tabel rekap_aplikasi
        $rekap = RekapAplikasi::find($validated['rekap_aplikasi_id']);
        $rekap->undangan_terakhir = $rekap->undangan()->latest('tanggal_assessment')->value('tanggal_assessment');
        // Tambahkan update status ke 'development'
        $rekap->status = 'development';
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
            'tanggal_assessment' => 'required|date',
            'surat_undangan' => 'nullable|file|mimes:pdf,doc,docx',
            'link_zoom_meeting' => 'nullable|string',
            'tanggal_zoom_meeting' => 'nullable|date',
            'waktu_zoom_meeting' => 'nullable|string',
            'tempat' => 'nullable|string',
        ]);

        if ($request->hasFile('surat_undangan')) {
            if ($undangan->surat_undangan) {
                Storage::disk('public')->delete($undangan->surat_undangan);
            }
            $validated['surat_undangan'] = $request->file('surat_undangan')
                ->store('undangan/surat', 'public');
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

        if ($undangan->surat_undangan) {
            Storage::disk('public')->delete($undangan->surat_undangan);
        }

        $undangan->delete();

        return redirect()->route('rekap-aplikasi.show', $apk_id)
            ->with('success', 'Undangan berhasil dihapus!');
    }
}
