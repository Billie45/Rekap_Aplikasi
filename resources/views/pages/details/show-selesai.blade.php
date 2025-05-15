@extends('layouts.app')
@section('content')

@php
$detailData = [
                ['label' => 'Organisasi Pemerintah Daerah', 'value' => $apk->opd->nama_opd ?? '-'],
                ['label' => 'Nama Aplikasi', 'value' => $apk->nama ?? '-'],
                ['label' => 'Nama Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
                ['label' => 'Status Assessment', 'value' => $apk->status_label ?? '-'],
                ['label' => 'Jenis Pengajuan Aplikasi', 'value' => $apk->tipe_label ?? '-'],
                ['label' => 'Jenis Pengembangan', 'value' => $apk->jenis_permohonan ?? '-'],
                ['label' => 'Tanggal Laporan Perbaikan / Rekom Lulus', 'value' => $apk->tanggal_masuk_ba ?? '-'],
                ['label' => 'Tanggal Masuk BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
                ['label' => 'Server Hosting', 'value' => $apk->server ?? '-'],
                ['label' => 'Keterangan Lanjutan', 'value' => $apk->keterangan ?? '-'],
            ];
@endphp

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail  Aplikasi yang Selesai</h4>
@include('components.template-tabel-2', ['data' => $detailData])

<div class="mt-4">
        <a href="{{ url('/selesai') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
