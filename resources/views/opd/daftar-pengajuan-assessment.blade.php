@extends('layouts.app')

@section('content')
    @include('components.template-tabel')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper mt-3">
        <table class="compact-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>OPD</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $apk)
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td>{{ $apk->opd->nama_opd ?? '-' }}</td>
                        <td>{{ $apk->nama }}</td>
                        <td>{{ $apk->jenis_assessment == 'Pertama' ? 'Pengajuan Pertama' : 'Pengajuan Revisi' }}</td>
                        <td>
                            @if($apk->status != 'perbaikan' && $apk->status != 'diproses')
                                Diterima
                            @elseif($apk->status == 'perbaikan' && $apk->jenis_jawaban == 'Ditolak')
                                Perlu Perbaikan
                            @elseif($apk->status == 'perbaikan' || $apk->status == 'diproses' && $apk->jenis_jawaban === null)
                                Menunggu Verifikasi
                            @else
                                Diproses
                            @endif
                        </td>
                        <td>
                            @if(Auth::user()->role == 'opd')
                                @if($apk->jenis_jawaban === null && $apk->status == 'perbaikan')
                                    Menunggu verifikasi admin
                                @elseif($apk->jenis_jawaban == 'Diterima')
                                    <span class="badge bg-success">Assessment diterima</span>
                                @elseif($apk->jenis_jawaban == 'Ditolak')
                                    <form action="{{ route('assessment.revisi', $apk->id) }}" method="GET" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Ajukan Revisi</button>
                                    </form>
                                @endif
                            @elseif(Auth::user()->role == 'admin')
                                @if($apk->jenis_jawaban === null)
                                    <form action="{{ route('assessment.terima', $apk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Diterima</button>
                                    </form>
                                    <form action="{{ route('assessment.tolak', $apk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Ditolak</button>
                                    </form>
                                @elseif($apk->jenis_jawaban == 'Diterima')
                                    <span class="badge bg-success">Assessment diterima</span>
                                @elseif($apk->jenis_jawaban == 'Ditolak')
                                    <span class="badge bg-secondary">Assessment ditunda</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @php
                                $routeName = Auth::user()->role === 'admin' ? 'admin.show-apk' : 'opd.show-apk';
                            @endphp
                            <a href="{{ route($routeName, $apk->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
