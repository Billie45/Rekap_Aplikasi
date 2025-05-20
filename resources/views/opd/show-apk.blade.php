@extends('layouts.app')
@section('content')

@php
$detailData = [
    ['label' => 'Organisasi Pemerintah Daerah', 'value' => $apk->opd->nama_opd ?? '-'],
    ['label' => 'Nama Aplikasi', 'value' => $apk->nama ?? '-'],
    ['label' => 'Nama Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>': '-'],
    ['label' => 'Status Assessment', 'value' => $apk->status_label ?? '-'],
    ['label' => 'Jenis Permohonan', 'value' => $apk->jenis ?? '-'],
    ['label' => 'Jenis Pengajuan Aplikasi', 'value' => $apk->tipe_label ?? '-'],
    ['label' => 'Server Hosting', 'value' => $apk->server ?? '-'],
    ['label' => 'Keterangan', 'value' => $apk->keterangan ?? '-'],
    ['label' => 'Deskripsi Singkat Last Update', 'value' => $apk->last_update ?? '-'],
    ['label' => 'Jenis Pengembangan', 'value' => $apk->jenis_permohonan ?? '-'],
    ['label' => 'Tanggal Rekom Lulus / BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
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
    ['label' => 'Informasi Rekap Aplikasi', 'value' =>
        $apk->assesment_terakhir || $apk->permohonan || $apk->undangan_terakhir || $apk->laporan_perbaikan
            ? implode('<br>', [
                '<strong>Tanggal Assessment Terakhir    :</strong> ' . ($apk->assesment_terakhir ?? '-'),
                '<strong>Tanggal Permohonan             :</strong> ' . ($apk->permohonan ?? '-'),
                '<strong>Tanggal Undangan Terakhir      :</strong> ' . ($apk->undangan_terakhir ?? '-'),
                '<strong>Tanggal Laporan Perbaikan      :</strong> ' . ($apk->laporan_perbaikan ?? '-'),
            ])
            : '-'
    ],
    ['label' => 'Detail Akses Server', 'value' =>
        $apk->status_server || $apk->open_akses || $apk->close_akses || $apk->urgensi
            ? implode('<br>', [
                '<strong>Status             :</strong> ' . ($apk->status_server ?? '-'),
                '<strong>Tanggal Open Akses :</strong> ' . ($apk->open_akses ?? '-'),
                '<strong>Tanggal Close Akses:</strong> ' . ($apk->close_akses ?? '-'),
                '<strong>Urgensi            :</strong> ' . ($apk->urgensi ?? '-'),
            ])
            : '-'
    ],
];
@endphp

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail Assessment Aplikasi</h4>
@include('components.template-tabel-2', ['data' => $detailData])

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Daftar Undangan</h4>
<!-- Tabel Undangan -->
<div class="bg-white rounded shadow p-4 mt-4">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Undangan</th>
                <th>Assessment Dokumentasi</th>
                <th>Catatan Assessment</th>
                <th>Surat Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($apk->undangan as $index => $undangan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $undangan->tanggal_undangan ?? '-' }}</td>
                    <td>
                        @if($undangan->assessment_dokumentasi)
                            <a href="{{ asset('storage/' . $undangan->assessment_dokumentasi) }}" target="_blank" title="Lihat Dokumen">
                                <i class="bx bxs-file-pdf" style="font-size: 1.5rem; color: red;"></i>
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $undangan->catatan_assessment ?? '-' }}</td>
                    <td>
                        @if($undangan->surat_rekomendasi)
                            <a href="{{ asset('storage/' . $undangan->surat_rekomendasi) }}" target="_blank" title="Lihat Surat">
                                <i class="bx bxs-file-pdf" style="font-size: 1.5rem; color: red;"></i>
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data undangan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Riwayat Pengembangan aplikasi</h4>
<!-- Tabel Riwayat -->
<div class="bg-white rounded shadow p-4 mt-4">

@if($riwayatPengembangan->isEmpty())
    <p>Belum ada riwayat pengembangan untuk aplikasi ini.</p>
@else
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
                    <td><a href="{{ route('opd.show-apk', $riwayat->id) }}"><i class="bx bxs-show" style="font-size: 1.5rem; color:blue"></a></td>
                    <!-- Isi sesuai kolom tabel master_rekap_aplikasi -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</div>

<div class="mt-4">
        <a href="{{ route('opd.daftar-pengajuan-assessment') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
