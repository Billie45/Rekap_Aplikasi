@extends('layouts.app')
@section('content')

@php
    $detailData = [
                ['label' => 'Nama', 'value' => $apk->nama ?? '-'],
                ['label' => 'OPD', 'value' => $apk->opd->nama_opd ?? '-'],
                ['label' => 'Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
                ['label' => 'Tipe', 'value' => $apk->tipe_label ?? '-'],
                ['label' => 'Jenis', 'value' => $apk->jenis ?? '-'],
                ['label' => 'Status', 'value' => $apk->status_label],
                ['label' => 'Assessment Terakhir', 'value' => $apk->assesment_terakhir ?? '-'],
                ['label' => 'Rekom Lulus / BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
                ['label' => 'Server', 'value' => $apk->server ?? '-'],
                ['label' => 'Link, Dokumentasi', 'value' => $apk->link_dokumentasi ? '<a href="' . $apk->link_dokumentasi . '" target="_blank">LINK</a>' : '-'],
                ['label' => 'Keterangan', 'value' => $apk->keterangan ?? '-'],
    ];
@endphp

@include('components.template-tabel-2', ['data' => $detailData])

<div class="mt-4">
        <a href="{{ url('/rekap-aplikasi-view') }}" class="btn btn-secondary">← Kembali</a>
</div>

@endsection
