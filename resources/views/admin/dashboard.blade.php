@extends('layouts.app')

@section('content')
    {{-- <h1>Halaman Dashboard Admin</h1> --}}

        {{-- <div class="card-body d-flex justify-content-center gap-4">

            <a href="{{ route('admin.list-apk') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
                Daftar Aplikasi
            </a>
            <a href="/rekap-aplikasi" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
                Daftar Pengajuan Assessment
            </a>
            <a href="{{ route('admin.edit-role') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
                Kelola Akun
            </a>
        </div> --}}

        <div class="bg-white rounded shadow p-4 mt-4">
            @include('components.rekap-assessment-1', ['aplikasis' => $aplikasis])
        </div>

        <!-- Tabel Undangan -->
        <div class="bg-white rounded shadow p-4 mt-4">
            <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Daftar Undangan Assessment</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aplikasi</th>
                        <th>OPD</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
                        <th>Link Zoom</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($undangans as $index => $undangan)
                        <tr>
                            <td>{{ $undangans->firstItem() + $index }}</td>
                            <td>{{ $undangan->rekapAplikasi->nama }}</td>
                            <td>{{ $undangan->rekapAplikasi->opd->nama_opd }}</td>
                            <td>{{ $undangan->tanggal_zoom_meeting }}</td>
                            <td>{{ $undangan->waktu_zoom_meeting }}</td>
                            <td>{{ $undangan->tempat }}</td>
                            <td class="text-center">
                                @if($undangan->link_zoom_meeting)
                                    <a href="{{ $undangan->link_zoom_meeting }}" target="_blank" title="Join Zoom Meeting">
                                        <i class="bx bxs-video" style="font-size: 1.5rem; color: #2D8CFF;"></i>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $undangans->links() }}
        </div>

        <!-- Tabel Penilaian -->
        <div class="bg-white rounded shadow p-4 mt-4">
            <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Daftar Penilaian Assessment</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aplikasi</th>
                        <th>OPD</th>
                        <th>Keputusan Assessment</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penilaians as $index => $penilaian)
                        <tr>
                            <td>{{ $penilaians->firstItem() + $index }}</td>
                            <td>{{ $penilaian->rekapAplikasi->nama }}</td>
                            <td>{{ $penilaian->rekapAplikasi->opd->nama_opd }}</td>
                            <td>{{ str_replace('_', ' ', ucwords($penilaian->keputusan_assessment)) }}</td>
                            <td>{{ $penilaian->tanggal_deadline_perbaikan }}</td>
                            <td>
                                <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-primary btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $penilaians->links() }}
        </div>
@endsection


