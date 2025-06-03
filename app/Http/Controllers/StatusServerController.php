<?php

namespace App\Http\Controllers;

use App\Models\StatusServer;
use Illuminate\Http\Request;

class StatusServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statusServers = StatusServer::with('penilaian')->get();
        return view('status-servers.show', compact('statusServers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $penilaian = \App\Models\Penilaian::with('rekapAplikasi')->findOrFail($request->penilaian_id);
        return view('status-servers.create', compact('penilaian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'penilaian_id' => 'required|exists:penilaians,id|unique:status_servers,penilaian_id',
            'tanggal_masuk_server' => 'required|date',
            'status_server' => 'required|in:development,production,luar',
            'permohonan' => 'nullable|file|mimes:pdf',
            'dokumen_teknis' => 'nullable|file|mimes:pdf',
        ]);

        // Handle file uploads
        // if ($request->hasFile('permohonan')) {
        //     $validated['permohonan'] = $request->file('permohonan')->store('permohonan', 'public');
        // }
        // if ($request->hasFile('dokumen_teknis')) {
        //     $validated['dokumen_teknis'] = $request->file('dokumen_teknis')->store('dokumen_teknis', 'public');
        // }

        $statusServer = StatusServer::create($validated);

        // Redirect ke halaman show status server yang baru dibuat
       return redirect()->route('status-server.show', $statusServer->id)->with('success', 'Status server berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusServer $statusServer)
    {
        return view('status-servers.show', compact('statusServer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusServer $statusServer)
    {
        return view('status-servers.update', compact('statusServer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusServer $statusServer)
    {
        $validated = $request->validate([
            'tanggal_masuk_server' => 'required|date',
            'status_server' => 'required|in:development,production,luar',
            'permohonan' => 'nullable|file|mimes:pdf',
            'dokumen_teknis' => 'nullable|file|mimes:pdf',
        ]);

        // Handle file uploads
        // if ($request->hasFile('permohonan')) {
        //     $validated['permohonan'] = $request->file('permohonan')->store('permohonan', 'public');
        // }
        // if ($request->hasFile('dokumen_teknis')) {
        //     $validated['dokumen_teknis'] = $request->file('dokumen_teknis')->store('dokumen_teknis', 'public');
        // }

        $statusServer->update($validated);

        // Redirect ke halaman show status server yang diupdate
        return redirect()->route('status-server.show', $statusServer->id)->with('success', 'Status server berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusServer $statusServer)
    {
        $penilaianId = $statusServer->penilaian_id;
        $statusServer->delete();

        // Redirect ke halaman penilaian terkait atau halaman lain sesuai kebutuhan Anda
        return redirect()->route('penilaian.show', $penilaianId)->with('success', 'Status server berhasil dihapus.');
    }
}
