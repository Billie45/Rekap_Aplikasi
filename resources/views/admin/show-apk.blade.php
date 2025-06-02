@extends('layouts.app')
@section('content')

@php
$assessmentData = [
    ['label' => 'Tanggal Permohonan', 'value' => $apk->permohonan ?? '-'],
    ['label' => 'Status Assessment', 'value' => $apk->status_label ?? '-'],
    ['label' => 'Jenis Pengajuan', 'value' => $apk->jenis ?? '-'],
    ['label' => 'Organisasi Pemerintah Daerah', 'value' => $apk->opd->nama_opd ?? '-'],
    ['label' => 'Nama Aplikasi', 'value' => $apk->nama ?? '-'],
    ['label' => 'Nama Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>': '-'],
    ['label' => 'Jenis Pengajuan Aplikasi', 'value' => $apk->tipe_label ?? '-'],
    ['label' => 'Perihal Permohonan', 'value' => $apk->jenis_permohonan ?? '-'],
    ['label' => 'Link Dokumentasi', 'value' => $apk->link_dokumentasi ? '<a href="' . $apk->link_dokumentasi . '" target="_blank">LINK</a>' : '-' ],
    ['label' => 'Akun untuk Diskominfo', 'value' =>
        $apk->akun_link && $apk->akun_username && $apk->akun_password
            ? implode('<br>', [
                '<strong>Link Login :</strong> <a href="' . $apk->akun_link . '" target="_blank">LINK</a>',
                '<strong>Username   :</strong> ' . $apk->akun_username,
                '<strong>Password   :</strong> ' . $apk->akun_password,
            ])
            : '-'
    ],
    ['label' => 'Contact Person OPD', 'value' =>
        $apk->cp_opd_nama || $apk->cp_opd_no_telepon
            ? implode('<br>', [
                '<strong>Nama       :</strong> ' . ($apk->cp_opd_nama ?? '-'),
                '<strong>No Telepon :</strong> ' . ($apk->cp_opd_no_telepon ?? '-'),
            ])
            : '-'
    ],
    ['label' => 'Contact Person Pengembang', 'value' =>
        $apk->cp_pengembang_nama || $apk->cp_pengembang_no_telepon
            ? implode('<br>', [
                '<strong>Nama       :</strong> ' . ($apk->cp_pengembang_nama ?? '-'),
                '<strong>No Telepon :</strong> ' . ($apk->cp_pengembang_no_telepon ?? '-'),
            ])
            : '-'
    ],
    ['label' => 'Surat Permohonan', 'value' => isset($riwayatRevisiAssessment->surat_permohonan) ? '<a href="' . asset('storage/' . $riwayatRevisiAssessment->surat_permohonan) . '" target="_blank"><i class="bx bxs-file-pdf" style="font-size: 1.5rem; color: red;"></i></a>' : '-'],
    ['label' => 'Catatan Perbaikan dari Admin', 'value' => $riwayatRevisiAssessment->catatan ?? '-'],
];

$pengembanganData = [
    [
        'label' => 'Tanggal Permohonan',
        // 'value' => $riwayatPertama?->permohonan ?? $apk->permohonan ?? '-',
        'value' => $apk->permohonan ?? '-',
    ],
    [
        'label' => 'Tanggal Laporan Perbaikan',
        // 'value' => $riwayatTerakhir?->permohonan ?? $apk->laporan_perbaikan ?? '-',
        'value' => $apk->laporan_perbaikan ?? '-',
    ],
    ['label' => 'Tanggal Assessment Terakhir', 'value' => $apk->updated_at ?? '-'],
    ['label' => 'Tanggal Undangan Terakhir', 'value' => $apk->undangan_terakhir ?? '-'],
    ['label' => 'Tanggal Masuk BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
    ['label' => 'Keterangan', 'value' => $apk->keterangan ?? '-'],
    ['label' => 'Deskripsi Singkat Last Update', 'value' => $apk->last_update ?? '-'],
];

$serverHostingData = [
    ['label' => 'Server Hosting', 'value' => $apk->server ?? '-'],
    ['label' => 'Status Server', 'value' => $apk->status_server ?? '-'],
    ['label' => 'Tanggal Open Akses', 'value' => $apk->open_akses ?? '-'],
    ['label' => 'Tanggal Close Akses', 'value' => $apk->close_akses ?? '-'],
    ['label' => 'Urgensi', 'value' =>  $apk->urgensi ?? '-'],
];

$actionsData = [
    ['label' => 'Edit', 'value' => '<a href="' . route('rekap-aplikasi.edit', $apk->id) . '"><i class="bx bxs-edit" style="font-size: 1.5rem;"></i></a>'],
    ['label' => 'Hapus', 'value' =>
        '<form action="' . route('rekap-aplikasi.destroy', $apk->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus aplikasi ini?\')">
            ' . csrf_field() . '
            ' . method_field('DELETE') . '
            <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;"><i class="bx bxs-trash" style="font-size: 1.5rem; color: red;"></i></button>
        </form>'
    ],
];

    // Tambahkan ini untuk mencegah error undefined variable
    if (!isset($riwayatPengembangan)) {
        $riwayatPengembangan = collect();
    }
@endphp

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail Assessment Aplikasi</h4>
@include('components.template-tabel-2', ['data' => $assessmentData])

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail Riwayat Assessment</h4>
@include('components.template-tabel-2', ['data' => $pengembanganData])

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail Server Hosting</h4>
@include('components.template-tabel-2', ['data' => $serverHostingData])

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Aksi</h4>
@include('components.template-tabel-2', ['data' => $actionsData])

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Daftar Undangan</h4>

<!-- Tabel Undangan -->
<div class="bg-white rounded shadow p-4 mt-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Assessment</th>
                <th>Surat Undangan</th>
                <th>Link Zoom Meeting</th>
                <th>Tanggal Zoom Meeting</th>
                <th>Waktu Zoom Meeting</th>
                <th>Tempat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($apk->undangan ?? [] as $index => $undangan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $undangan->tanggal_assessment ?? '-' }}</td>
                    <td>
                        @if($undangan->surat_undangan)
                            <a href="{{ asset('storage/' . $undangan->surat_undangan) }}" target="_blank" title="Lihat Dokumen">
                                <i class="bx bxs-file-pdf" style="font-size: 1.5rem; color: red;"></i>
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($undangan->link_zoom_meeting)
                            <a href="{{ $undangan->link_zoom_meeting }}" target="_blank" style="color: blue; text-decoration: none;">
                                <i class='bx bxs-video' style="vertical-align: middle;"></i>
                                External Link
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $undangan->tanggal_zoom_meeting ?? '-' }}</td>
                    <td>{{ $undangan->waktu_zoom_meeting ?? '-' }}</td>
                    <td>{{ $undangan->tempat ?? '-' }}</td>
                    <td>
                        <a href="{{ route('undangan.edit', $undangan->id) }}">
                            <i class="bx bxs-edit" style="font-size: 1.5rem;"></i>
                        </a>
                        <form action="{{ route('undangan.destroy', $undangan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus undangan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;">
                                <i class="bx bxs-trash" style="font-size: 1.5rem; color: red;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data undangan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Riwayat Pengembangan aplikasi</h4>
<!-- Tabel Riwayat -->
<div class="bg-white rounded shadow p-4 mt-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengajuan</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>detail</th>
                <!-- Tambahkan kolom lain yang diperlukan -->
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatPengembangan as $index => $riwayat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $riwayat->permohonan ?? '-' }}</td>
                    <td>{{ $riwayat->jenis ?? '-' }}</td>
                    <td>{{ $riwayat->status ?? '-' }}</td>
                    <td><a href="{{ route('admin.show-apk', $riwayat->id) }}"><i class="bx bxs-show" style="font-size: 1.5rem; color:blue"></a></td>
                    <!-- Isi sesuai kolom tabel master_rekap_aplikasi -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    <a href="{{ route('admin.list-apk') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
