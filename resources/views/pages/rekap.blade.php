@extends('layouts.app')

@section('content')
    {{-- <h1>Halaman Rekap Aplikasi</h1> --}}

    {{-- Template tabel --}}
    @include('components.template-tabel')

    <div class="table-wrapper mt-3">
        <table class="compact-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>OPD</th>
                    <th>Subdomain</th>
                    <th>Tipe</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Assessment Terakhir</th>
                    <th>Rekom Lulus / BA</th>
                    <th>Server</th>
                    <th>Link, Dokumentasi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $index => $apk)
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td>{{ $apk->nama ?? '-' }}</td>
                        <td>{{ $apk->opd->nama_opd ?? '-' }}</td>
                        <td>
                            @if ($apk->subdomain)
                                <a href="https://{{ $apk->subdomain }}" target="_blank">{{ $apk->subdomain }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $apk->tipe_label ?? '-' }}</td>
                        <td>{{ $apk->jenis ?? '-' }}</td>
                        <td>{{ $apk->status_label }}</td>
                        <td>{{ $apk->assesment_terakhir ?? '-' }}</td>
                        <td>{{ $apk->tanggal_masuk_ba ?? '-' }}</td>
                        <td>{{ $apk->server ?? '-' }}</td>
                        <td>
                            @if ($apk->link_dokumentasi)
                                <a href="{{ $apk->link_dokumentasi }}" target="_blank">LINK</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $apk->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class ="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
