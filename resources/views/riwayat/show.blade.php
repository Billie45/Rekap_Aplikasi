@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Detail Riwayat Revisi Assessment
                </h5>
            </div>
        </div>

        <div class="card-body p-4">
            <table class="table table-bordered">
                <tr>
                    <th class="bg-light">Tanggal Pengajuan</th>
                    <td>
                        @if($riwayat->permohonan)
                            {{ \Carbon\Carbon::parse($riwayat->permohonan)->format('d F Y') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                {{-- <tr>
                    <th class="bg-light" style="width: 200px;">ID</th>
                    <td>{{ $riwayat->id }}</td>
                </tr> --}}
                {{-- <tr>
                    <th class="bg-light">Permohonan</th>
                    <td>{{ $riwayat->permohonan }}</td>
                </tr> --}}
                {{-- <tr>
                    <th class="bg-light">Rekap Aplikasi</th>
                    <td>{{ optional($riwayat->rekapAplikasi)->nama ?? '-' }}</td>
                </tr> --}}
                {{-- <tr>
                    <th class="bg-light">OPD ID</th>
                    <td>{{ $riwayat->opd_id }}</td>
                </tr> --}}
                <tr>
                    <th class="bg-light">Jenis</th>
                    <td>{{ $riwayat->jenis }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Nama</th>
                    <td>{{ $riwayat->nama }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Subdomain</th>
                    <td>{{ $riwayat->subdomain }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Tipe</th>
                    <td>{{ $riwayat->tipe_label }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Jenis Permohonan</th>
                    <td>{{ $riwayat->jenis_permohonan }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Link Dokumentasi</th>
                    <td>
                        @if($riwayat->link_dokumentasi)
                            <a href="{{ $riwayat->link_dokumentasi }}" target="_blank">{{ $riwayat->link_dokumentasi }}</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="bg-light">Akun Link</th>
                    <td>
                        @if($riwayat->akun_link)
                            <a href="{{ $riwayat->akun_link }}" target="_blank">{{ $riwayat->akun_link }}</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="bg-light">Akun Username</th>
                    <td>{{ $riwayat->akun_username ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Akun Password</th>
                    <td>{{ $riwayat->akun_password ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">CP OPD</th>
                    <td>{{ $riwayat->cp_opd_nama ?? '-' }} ({{ $riwayat->cp_opd_no_telepon ?? '-' }})</td>
                </tr>
                <tr>
                    <th class="bg-light">CP Pengembang</th>
                    <td>{{ $riwayat->cp_pengembang_nama ?? '-' }} ({{ $riwayat->cp_pengembang_no_telepon ?? '-' }})</td>
                </tr>
                <tr>
                    <th class="bg-light">Surat Permohonan</th>
                    <td>
                        @if($riwayat->surat_permohonan)
                            <a href="{{ asset('storage/' . $riwayat->surat_permohonan) }}"
                               target="_blank"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-file-pdf me-1"></i>
                                Lihat Surat
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="bg-light">Catatan</th>
                    <td>{{ $riwayat->catatan ?? '-' }}</td>
                </tr>

            </table>

            <div class="mt-3">
                @php
                    $role = Auth::user()->role; // Pastikan kolom `role` ada di tabel users
                @endphp

                <a href="{{ url(($role == 'admin' ? 'admin' : 'opd') . '/show-apk/' . $riwayat->rekap_aplikasi_id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
