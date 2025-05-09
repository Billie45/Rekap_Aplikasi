@extends('layouts.app')
@section('content')
    {{-- <h1>Halaman Assessment</h1> --}}

    {{-- Template tabel --}}
    @include('components.template-tabel')

    <div class="table-wrapper mt-3">
        <table class="compact-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>OPD</th>
                    <th>Nama</th>
                    <th>Subdomain</th>
                    <th>Status</th>
                    <th>Progres</th>
                    <th>Jenis</th>
                    <th>Last Update</th>
                    <th>Jenis Permohonan</th>
                    <th>Permohonan</th>
                    <th>Undangan Terakhir</th>
                    <th>Rekom Terakhir</th>
                    <th>Laporan Perbaikan</th>
                    <th>Dok. Teknis</th>
                    <th>Akun</th>
                    <th>CP OPD</th>
                    <th>CP Pengembang</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $index => $apk)
                    @continue(!in_array($apk->status, ['perbaikan', 'assessment1', 'assessment2']))
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td>{{ $apk->opd->nama_opd ?? '-'  }}</td>
                        <td>{{ $apk->nama ?? '-' }}</td>
                        <td>
                            @if ($apk->subdomain)
                                <a href="https://{{ $apk->subdomain }}" target="_blank">{{ $apk->subdomain }}</a>
                            @else
                                -
                            @endif
                        </td>
                        {{-- Kolom Status --}}
                        <td>
                            @if(in_array($apk->status, ['assessment1', 'assessment2']))
                                assessment
                            @elseif($apk->status == 'perbaikan')
                                perbaikan
                            @else
                                -
                            @endif
                        </td>
                        {{-- Kolom Progres --}}
                        <td>
                            @if($apk->status == 'assessment1')
                                assessment 1
                            @elseif($apk->status == 'assessment2')
                                assessment 2
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $apk->tipe_label ?? '-' }}</td>
                        <td>{{ $apk->last_update ?? '-' }}</td>
                        <td>{{ $apk->jenis_permohonan ?? '-' }}</td>
                        <td>{{ $apk->permohonan ?? '-' }}</td>
                        <td>{{ $apk->undangan_terakhir ?? '-' }}</a></td>
                        <td>{{ $apk->tanggal_masuk_ba ?? '-' }}</td>
                        <td>{{ $apk->laporan_perbaikan ?? '-' }}</td>
                        <td>
                            @if ($apk->link_dokumentasi)
                                <a href="{{ $apk->link_dokumentasi }}" target="_blank">LINK</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($apk->akun_link && $apk->akun_username && $apk->akun_password)
                                <strong>Link:</strong> <a href="{{ $apk->akun_link }}" target="_blank">LINK</a><br>
                                <strong>Username:</strong> {{ $apk->akun_username }}<br>
                                <strong>Password:</strong> {{ $apk->akun_password }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($apk->cp_opd_nama && $apk->cp_opd_no_telepon)
                                <strong>Nama OPD:</strong> {{ $apk->cp_opd_nama }}<br>
                                <strong>No. Telepon:</strong> {{ $apk->cp_opd_no_telepon }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($apk->cp_pengembang_nama && $apk->cp_pengembang_no_telepon)
                                <strong>Nama Pengembang:</strong> {{ $apk->cp_pengembang_nama }}<br>
                                <strong>No. Telepon:</strong> {{ $apk->cp_pengembang_no_telepon }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class ="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
