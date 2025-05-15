@extends('layouts.app')
@section('content')

@php
    $detailData = [
        ['label' => 'Organisasi Pemerintah Daerah', 'value' => $apk->opd->nama_opd ?? '-'],
        ['label' => 'Nama Aplikasi', 'value' => $apk->nama ?? '-'],
        ['label' => 'Nama Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-'],
        ['label' => 'Progres Assessment', 'value' =>
            $apk->status == 'assessment1' || $apk->status == 'assessment2'
            ? 'Assessment'
            : ($apk->status == 'perbaikan' ? 'Perbaikan' : $apk->status)
        ],
        ['label' => 'Status Assessment', 'value' =>
            $apk->status == 'assessment1' ? 'Assessment 1' :
            ($apk->status == 'assessment2' ? 'Assessment 2' :
            ($apk->status == 'perbaikan' ? '-' : $apk->status))
        ],
        ['label' => 'Jenis Pengajuan Aplikasi', 'value' => $apk->tipe_label ?? '-'],
        ['label' => 'Deskripsi Singkat Last Update', 'value' => $apk->last_update ?? '-'],
        ['label' => 'Jenis Permohonan', 'value' => $apk->jenis_permohonan ?? '-'],
        ['label' => 'Tanggal Permohonan', 'value' => $apk->permohonan ?? '-'],
        ['label' => 'Tanggal Undangan Terakhir', 'value' => $apk->undangan_terakhir ?? '-'],
        ['label' => 'Tanggal Rekom Terakhir', 'value' => $apk->tanggal_masuk_ba ?? '-'],
        ['label' => 'Tanggal Laporan Perbaikan', 'value' => $apk->laporan_perbaikan ?? '-'],
        ['label' => 'Dokumentasi Teknis', 'value' => $apk->link_dokumentasi ? '<a href="' . $apk->link_dokumentasi . '" target="_blank">LINK</a>' : '-'],
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
        ];
@endphp

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Detail Tahap Assessment Aplikasi</h4>
@include('components.template-tabel-2', ['data' => $detailData])

<div class="mt-4">
        <a href="{{ url('/assessment') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
