@extends('layouts.app')
@section('content')

@php
    $detailData= [
                ['label' => 'OPD', 'value' => $apk->opd->nama_opd ?? '-'],
                ['label' => 'Nama', 'value' => $apk->nama ?? '-'],
                ['label' => 'Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
                ['label' => 'Ket Progress', 'value' => $apk->status_label ?? '-'],
                ['label' => 'Jenis', 'value' => $apk->tipe_label ?? '-'],
                ['label' => 'Tgl Masuk / BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
                ['label' => 'Server', 'value' => $apk->server ?? '-'],
                ['label' => 'Last Update', 'value' => $apk->last_update ?? '-'],
                ['label' => 'Jenis Permohonan', 'value' => $apk->jenis_permohonan ?? '-'],
                ['label' => 'Akun', 'value' => $apk->akun_link && $apk->akun_username && $apk->akun_password ?
                    '<strong>Link:</strong> <a href="' . $apk->akun_link . '" target="_blank">LINK</a><br>
                    <strong>Username:</strong> ' . $apk->akun_username . '<br>
                    <strong>Password:</strong> ' . $apk->akun_password : '-'],
                ['label' => 'CP OPD', 'value' => $apk->cp_opd_nama && $apk->cp_opd_no_telepon ?
                    '<strong>Nama OPD:</strong> ' . $apk->cp_opd_nama . '<br><strong>No. Telepon:</strong> ' . $apk->cp_opd_no_telepon : '-'],
                ['label' => 'CP Pengembang', 'value' => $apk->cp_pengembang_nama && $apk->cp_pengembang_no_telepon ?
                    '<strong>Nama Pengembang:</strong> ' . $apk->cp_pengembang_nama . '<br><strong>No. Telepon:</strong> ' . $apk->cp_pengembang_no_telepon : '-'],
            ];
@endphp

@include('components.template-tabel-2', ['data' => $detailData])

<div class="mt-4">
        <a href="{{ url('/development') }}" class="btn btn-secondary">← Kembali</a>
</div>

@endsection
