@extends('layouts.app')

@section('content')
    {{-- <h1>Halaman Dashboard OPD</h1> --}}

    {{-- <div class="d-flex justify-content-center gap-4 my-4">
        <a href="{{ route('opd.form-pengajuan-assessment') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
            Tambah Pengajuan Assessment
        </a>
        <a href="{{ route('opd.daftar-pengajuan-assessment') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
            Daftar Pengajuan Assessment
        </a>
    </div> --}}
    <div class="bg-white rounded shadow p-4 mt-4">
        @include('components.rekap-assessment-1', ['aplikasis' => $aplikasis])
    </div>

    <!-- Tabel Undangan -->
    <div class="bg-white rounded shadow p-4 mt-4">
        <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Daftar Undangan Assessment
        </h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Aplikasi</th>
                    <th>Surat Undangan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Tempat</th>
                    <th>Link Zoom</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $opdId = Auth::user()->opd_id;
                    $aplikasis = \App\Models\RekapAplikasi::where('opd_id', $opdId)->with('undangan')->get();
                @endphp
                @forelse ($aplikasis->pluck('undangan')->flatten() as $index => $undangan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $undangan->rekapAplikasi->nama }}</td>
                        <td class="text-center">
                            @if ($undangan->surat_undangan)
                                <a href="{{ asset('storage/' . $undangan->surat_undangan) }}" target="_blank"
                                    title="Lihat Dokumen">
                                    <i class="bx bxs-file-pdf" style="font-size: 1.5rem; color: red;"></i>
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $undangan->tanggal_zoom_meeting ?? '-' }}</td>
                        <td>{{ $undangan->waktu_zoom_meeting ?? '-' }}</td>
                        <td>{{ $undangan->tempat ?? '-' }}</td>
                        <td class="text-center">
                            @if ($undangan->link_zoom_meeting)
                                <a href="{{ $undangan->link_zoom_meeting }}" target="_blank"
                                    title="Join Zoom Meeting">
                                    <i class="bx bxs-video" style="font-size: 1.5rem; color: #2D8CFF;"></i>
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data undangan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel Penilaian -->
    <div class="bg-white rounded shadow p-4 mt-4">
        <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Daftar Penilaian Assessment
        </h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Aplikasi</th>
                    <th>Keputusan Assessment</th>
                    <th>Tanggal Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $penilaians = \App\Models\Penilaian::whereHas('rekapAplikasi', function($query) use ($opdId) {
                        $query->where('opd_id', $opdId);
                    })->get();
                @endphp
                @forelse ($penilaians as $index => $penilaian)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $penilaian->rekapAplikasi->nama }}</td>
                        <td>{{ str_replace('_', ' ', ucwords($penilaian->keputusan_assessment)) }}</td>
                        <td>{{ $penilaian->tanggal_deadline_perbaikan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-primary btn-sm">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data penilaian</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
