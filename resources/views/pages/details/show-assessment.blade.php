@extends('layouts.app')
@section('content')

@php
    $detailData = [
        ['label' => 'OPD', 'value' => $apk->opd->nama_opd ?? '-'],
        ['label' => 'Nama', 'value' => $apk->nama ?? '-'],
        ['label' => 'Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
        ['label' => 'Status', 'value' => $apk->status],
        ['label' => 'Progres', 'value' => $apk->status == 'assessment1' ? 'assessment 1' : ($apk->status == 'assessment2' ? 'assessment 2' : $apk->status)],
        ['label' => 'Jenis', 'value' => $apk->tipe_label ?? '-'],
        ['label' => 'Last Update', 'value' => $apk->last_update ?? '-'],
        ['label' => 'Jenis Permohonan', 'value' => $apk->jenis_permohonan ?? '-'],
        ['label' => 'Permohonan', 'value' => $apk->permohonan ?? '-'],
        ['label' => 'Undangan Terakhir', 'value' => $apk->undangan_terakhir ?? '-'],
        ['label' => 'Rekom Terakhir', 'value' => $apk->tanggal_masuk_ba ?? '-'],
        ['label' => 'Laporan Perbaikan', 'value' => $apk->laporan_perbaikan ?? '-'],
        ['label' => 'Dok. Teknis', 'value' => $apk->link_dokumentasi ? '<a href="' . $apk->link_dokumentasi . '" target="_blank">LINK</a>' : '-'],
        ['label' => 'Akun', 'value' => ($apk->akun_link && $apk->akun_username && $apk->akun_password) ? '<strong>Link:</strong> <a href="' . $apk->akun_link . '" target="_blank">LINK</a><br> <strong>Username:</strong> ' . $apk->akun_username . '<br> <strong>Password:</strong> ' . $apk->akun_password : '-'],
        ['label' => 'CP OPD', 'value' => ($apk->cp_opd_nama && $apk->cp_opd_no_telepon) ? '<strong>Nama:</strong> ' . $apk->cp_opd_nama . '<br><strong>No. Telepon:</strong> ' . $apk->cp_opd_no_telepon : '-'],
        ['label' => 'CP Pengembang', 'value' => ($apk->cp_pengembang_nama && $apk->cp_pengembang_no_telepon) ? '<strong>Nama:</strong> ' . $apk->cp_pengembang_nama . '<br><strong>No. Telepon:</strong> ' . $apk->cp_pengembang_no_telepon : '-'],
    ];
@endphp

@include('components.template-tabel-2', ['data' => $detailData])

<div class="mt-4">
        <a href="{{ url('/assessment') }}" class="btn btn-secondary">← Kembali</a>
</div>

@endsection
