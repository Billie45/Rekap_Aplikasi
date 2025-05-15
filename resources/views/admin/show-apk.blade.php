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
    ['label' => 'Tools', 'value' =>
        implode('', [
            '<a href="' . route('rekap-aplikasi.edit', $apk->id) . '">Edit</a><br>',
            '<form action="' . route('rekap-aplikasi.destroy', $apk->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus aplikasi ini?\')">',
                csrf_field(),
                method_field('DELETE'),
                '<button type="submit" style="color: red">Hapus</button>',
            '</form>',
        ])
    ],
];
@endphp

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail Assessment Aplikasi</h4>
@include('components.template-tabel-2', ['data' => $detailData])

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Daftar Undangan</h4>

<div class="mt-4">
    @if($apk->status === 'selesai')
        <a href="{{ route('undangan.create', ['apk_id' => $apk->id]) }}" class="btn btn-primary">Buat Undangan</a>
    @endif
</div>
<!-- Tabel Undangan -->
@include('components.template-tabel')
    <div class="bg-white rounded shadow p-4 mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Undangan</th>
                    <th>Assessment Dokumentasi</th>
                    <th>Catatan Assessment</th>
                    <th>Surat Rekomendasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($apk->undangan as $index => $undangan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $undangan->tanggal_undangan ?? '-' }}</td>
                        <td>
                            @if($undangan->assessment_dokumentasi)
                                <a href="{{ asset('storage/' . $undangan->assessment_dokumentasi) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $undangan->catatan_assessment ?? '-' }}</td>
                        <td>
                            @if($undangan->surat_rekomendasi)
                                <a href="{{ asset('storage/' . $undangan->surat_rekomendasi) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('undangan.edit', $undangan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('undangan.destroy', $undangan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus undangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
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

<div class="mt-4">

    <a href="{{ route('admin.list-apk') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
