<?php

namespace App\Http\Controllers;

use App\Models\BA;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BAController extends Controller
{
    /**
     * Display a listing of BAs
     */
    public function index()
    {
        $bas = BA::with('penilaian.rekapAplikasi')->latest()->paginate(10);
        return view('ba.index', compact('bas'));
    }

    /**
     * Show the form for creating a new BA
     */
    public function create(Request $request)
    {
        $penilaian = Penilaian::findOrFail($request->penilaian_id);
        return view('ba.create', compact('penilaian'));
    }

    /**
     * Store a newly created BA
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'penilaian_id' => 'required|exists:penilaians,id',
            'tanggal_pelaksanaan' => 'required|date',
            'ringkasan_hasil' => 'required|string',
            // 'dokumen_ba' => 'required|file|mimes:pdf'

            'dokumen_ba' => 'nullable|file|mimes:pdf'
        ]);

        if ($request->hasFile('dokumen_ba')) {
            $path = $request->file('dokumen_ba')->store('ba-documents', 'public');
            $validated['dokumen_ba'] = $path;
        }

        $ba = BA::create($validated);

        // Update status dan tanggal_masuk_ba pada rekap aplikasi
        $ba->penilaian->rekapAplikasi->update([
            'status' => 'selesai',
            'tanggal_masuk_ba' => $ba->tanggal_pelaksanaan
        ]);

        return redirect()
            ->route('ba.show', $ba->id)
            ->with('success', 'Berita Acara berhasil dibuat');
    }

    /**
     * Display the specified BA
     */
    public function show(BA $ba)
    {
        $ba->load('penilaian.rekapAplikasi');
        return view('ba.show', compact('ba'));
    }

    /**
     * Show the form for editing the specified BA
     */
    public function edit(BA $ba)
    {
        $ba->load('penilaian.rekapAplikasi');
        return view('ba.update', compact('ba'));
    }

    /**
     * Update the specified BA
     */
    public function update(Request $request, BA $ba)
    {
        $validated = $request->validate([
            'tanggal_pelaksanaan' => 'required|date',
            'ringkasan_hasil' => 'required|string',
            'dokumen_ba' => 'nullable|file|mimes:pdf'
        ]);

        if ($request->hasFile('dokumen_ba')) {
            // Delete old file if exists
            if ($ba->dokumen_ba) {
                Storage::disk('public')->delete($ba->dokumen_ba);
            }

            $path = $request->file('dokumen_ba')->store('ba-documents', 'public');
            $validated['dokumen_ba'] = $path;
        }

        $ba->update($validated);

        // Update tanggal_masuk_ba pada rekap aplikasi
        $ba->penilaian->rekapAplikasi->update([
            'tanggal_masuk_ba' => $ba->tanggal_pelaksanaan
        ]);

        return redirect()
            ->route('ba.show', $ba->id)
            ->with('success', 'Berita Acara berhasil diperbarui');
    }

    /**
     * Remove the specified BA
     */
    public function destroy(BA $ba)
    {
        // Delete associated file if exists
        if ($ba->dokumen_ba) {
            Storage::disk('public')->delete($ba->dokumen_ba);
        }

        // Update status rekap aplikasi kembali ke 'prosesBA'
        $ba->penilaian->rekapAplikasi->update([
            'status' => 'prosesBA'
        ]);

        $ba->delete();

        return redirect()
            ->route('ba.index')
            ->with('success', 'Berita Acara berhasil dihapus');
    }
}
