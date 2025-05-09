@extends('layouts.app')
@section('content')
    {{-- <h1>Halaman Development</h1> --}}

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
                    <th>Ket Progress</th>
                    <th>Jenis</th>
                    <th>Tgl Masuk / BA</th>
                    <th>Server</th>
                    <th>Last Update</th>
                    <th>Jenis Permohonan</th>
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
                    @continue(!in_array($apk->status, ['development', 'prosesBA']))
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
                        <td>{{ $apk->status_label ?? '-' }}</td>
                        <td>{{ $apk->tipe_label ?? '-' }}</td>
                        <td>{{ $apk->tanggal_masuk_ba ?? '-' }}</td>
                        <td>{{ $apk->server ?? '-' }}</td>
                        <td>{{ $apk->last_update ?? '-' }}</td>
                        <td>{{ $apk->jenis_permohonan ?? '-' }}</td>
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
