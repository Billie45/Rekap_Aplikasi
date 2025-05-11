@extends('layouts.app')
@section('content')

@php
$detailData = [
                ['label' => 'OPD', 'value' => $apk->opd->nama_opd ?? '-'],
                ['label' => 'Nama', 'value' => $apk->nama ?? '-'],
                ['label' => 'Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
                ['label' => 'Status', 'value' => $apk->status_label ?? '-'],
                ['label' => 'Jenis', 'value' => $apk->tipe_label ?? '-'],
                ['label' => 'Jenis Permohonan', 'value' => $apk->jenis_permohonan ?? '-'],
                ['label' => 'Laporan Perbaikan / Rekom Lulus', 'value' => $apk->tanggal_masuk_ba ?? '-'],
                ['label' => 'BA', 'value' => $apk->tanggal_masuk_ba ?? '-'],
                ['label' => 'Server', 'value' => $apk->server ?? '-'],
                ['label' => 'Keterangan Lanjutan', 'value' => $apk->keterangan ?? '-'],
            ];
@endphp

@include('components.template-tabel-2', ['data' => $detailData])

<div class="mt-4">
        <a href="{{ url('/selesai') }}" class="btn btn-secondary">← Kembali</a>
</div>

@endsection
