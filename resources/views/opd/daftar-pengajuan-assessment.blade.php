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
                    {{-- <th>Subdomain</th> --}}
                    <th>Jenis</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $index => $apk)
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td>{{ $apk->opd->nama_opd ?? '-' }}</td>
                        <td>{{ $apk->nama }}</td>
                        {{-- <td>
                            @if ($apk->subdomain)
                                <a href="https://{{ $apk->subdomain }}" target="_blank">{{ $apk->subdomain }}</a>
                            @else
                                -
                            @endif
                        </td> --}}
                        <td>{{ $apk->tipe_label }}</td>
                        <td>{{ $apk->status_label }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class ="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
