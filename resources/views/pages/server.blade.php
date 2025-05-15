@extends('layouts.app')
@section('content')
    {{-- <h1>Halaman Akses Server</h1> --}}

    {{-- Template tabel --}}
    @include('components.template-tabel')

    <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Daftar Status Hosting dan Akses Server Aplikasi</h4>

    <div class="table-wrapper mt-3">
        <table class="compact-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Organisasi Pemerintah Daerah</th>
                    <th>Nama Aplikasi </th>
                    <th>Nama Subdomain</th>
                    <th>Status Server</th>
                    <th>Server Hosting</th>
                    <th>Open Akses</th>
                    <th>Close Akses</th>
                    <th>Urgensi</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $index => $apk)
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
                        <td>{{ $apk->status_server ?? '-'  }}</td>
                        <td>{{ $apk->server ?? '-' }}</td>
                        <td>{{ $apk->open_akses ?? '-' }}</td>
                        <td>{{ $apk->close_akses ?? '-' }}</td>
                        <td>{{ $apk->urgensi ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class ="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
