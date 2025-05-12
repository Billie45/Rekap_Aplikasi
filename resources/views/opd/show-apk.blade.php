@extends('layouts.app')
@section('content')

@php
$detailData = [
    ['label' => 'OPD', 'value' => $apk->opd->nama_opd ?? '-'],
    ['label' => 'Nama Aplikasi', 'value' => $apk->nama ?? '-'],
    ['label' => 'Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
    ['label' => 'Status', 'value' => $apk->status_label ?? '-'],
    ['label' => 'Jenis', 'value' => $apk->jenis ?? '-'],
    ['label' => 'Tipe', 'value' => $apk->tipe_label ?? '-'],
    ['label' => 'Server', 'value' => $apk->server ?? '-'],
    ['label' => 'Keterangan', 'value' => $apk->keterangan ?? '-'],
    ['label' => 'Last Update', 'value' => $apk->last_update ?? '-'],
    ['label' => 'Jenis Permohonan', 'value' => $apk->jenis_permohonan ?? '-'],
    ['label' => 'Tanggal Masuk / BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
    ['label' => 'Link Dokumentasi', 'value' => $apk->link_dokumentasi ? '<a href="' . $apk->link_dokumentasi . '" target="_blank">LINK</a>' : '-'],

    ['label' => 'Akun', 'value' =>
        $apk->akun_link && $apk->akun_username && $apk->akun_password
        ? '<strong>Link:</strong> <a href="' . $apk->akun_link . '" target="_blank">LINK</a><br>
           <strong>Username:</strong> ' . $apk->akun_username . '<br>
           <strong>Password:</strong> ' . $apk->akun_password
        : '-'],

    ['label' => 'CP OPD', 'value' =>
        $apk->cp_opd_nama || $apk->cp_opd_no_telepon
        ? '<strong>Nama:</strong> ' . ($apk->cp_opd_nama ?? '-') . '<br>
           <strong>No Telepon:</strong> ' . ($apk->cp_opd_no_telepon ?? '-')
        : '-'],

    ['label' => 'CP Pengembang', 'value' =>
        $apk->cp_pengembang_nama || $apk->cp_pengembang_no_telepon
        ? '<strong>Nama:</strong> ' . ($apk->cp_pengembang_nama ?? '-') . '<br>
           <strong>No Telepon:</strong> ' . ($apk->cp_pengembang_no_telepon ?? '-')
        : '-'],

    ['label' => 'Rekap Aplikasi', 'value' =>
        $apk->assesment_terakhir || $apk->permohonan || $apk->undangan_terakhir || $apk->laporan_perbaikan
        ? '<strong>Assessment Terakhir:</strong> ' . ($apk->assesment_terakhir ?? '-') . '<br>
           <strong>Permohonan:</strong> ' . ($apk->permohonan ?? '-') . '<br>
           <strong>Undangan Terakhir:</strong> ' . ($apk->undangan_terakhir ?? '-') . '<br>
           <strong>Laporan Perbaikan:</strong> ' . ($apk->laporan_perbaikan ?? '-')
        : '-'],

    ['label' => 'Server', 'value' =>
        $apk->status_server || $apk->open_akses || $apk->close_akses || $apk->urgensi
        ? '<strong>Status:</strong> ' . ($apk->status_server ?? '-') . '<br>
           <strong>Open Akses:</strong> ' . ($apk->open_akses ?? '-') . '<br>
           <strong>Close Akses:</strong> ' . ($apk->close_akses ?? '-') . '<br>
           <strong>Urgensi:</strong> ' . ($apk->urgensi ?? '-')
        : '-'],

];
@endphp

@include('components.template-tabel-2', ['data' => $detailData])

<!-- Tabel Undangan -->
<div class="mt-4">
    <h4>Daftar Undangan</h4>
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
        <a href="{{ route('opd.daftar-pengajuan-assessment') }}" class="btn btn-secondary">← Kembali</a>
</div>

@endsection
