@extends('layouts.app')
@section('content')

@php
    $detailData = [
                ['label' => 'Nama Aplikasi', 'value' => $apk->nama ?? '-'],
                ['label' => 'Organisasi Pemerintah Daerah', 'value' => $apk->opd->nama_opd ?? '-'],
                ['label' => 'Nama Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
                ['label' => 'Jenis Pengajuan Aplikasi', 'value' => $apk->tipe_label ?? '-'],
                ['label' => 'Jenis Pemohonan', 'value' => $apk->jenis ?? '-'],
                ['label' => 'Status Assessment', 'value' => $apk->status_label],
                ['label' => 'Tanggal Assessment Terakhir', 'value' => $apk->assesment_terakhir ?? '-'],
                ['label' => 'Tanggal Rekom Lulus / BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
                ['label' => 'Server Hosting', 'value' => $apk->server ?? '-'],
                ['label' => 'Link Dokumentasi', 'value' => $apk->link_dokumentasi ? '<a href="' . $apk->link_dokumentasi . '" target="_blank">LINK</a>' : '-'],
                ['label' => 'Keterangan', 'value' => $apk->keterangan ?? '-'],
    ];
@endphp

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail  Rekap Assessment Aplikasi</h4>
@include('components.template-tabel-2', ['data' => $detailData])

<div class="mt-4">
        <a href="{{ url('/rekap-aplikasi-view') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
