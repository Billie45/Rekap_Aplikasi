@extends('layouts.app')
@section('content')
    {{-- <h1>Halaman Selesai</h1> --}}

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
                    <th>Jenis</th>
                    <th>Jenis Permohonan</th>
                    <th>Laporan Perbaikan / Rekom Lulus</th>
                    <th>BA</th>
                    <th>Server</th>
                    <th>Keterangan Lanjutan</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $index => $apk)
                    @continue(!in_array($apk->status, ['selesai', 'batal']))
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
                        <td>{{ $apk->jenis_permohonan ?? '-' }}</td>
                        <td>{{ $apk->tanggal_masuk_ba ?? '-' }}</td>
                        <td>{{ $apk->tanggal_masuk_ba ?? '-' }}</td>
                        <td>{{ $apk->server ?? '-' }}</td>
                        <td>{{ $apk->keterangan?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class ="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
