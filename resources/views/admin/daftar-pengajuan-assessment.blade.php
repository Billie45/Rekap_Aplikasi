{{-- filepath: d:\File\xampp\htdocs\Rekap_aplikasi\resources\views\admin\daftar-pengajuan-assessment.blade.php --}}
@extends('layouts.app')

@section('content')
    @include('components.template-tabel')

    <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Manajemen Pengajuan Assessment Aplikasi</h4>

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
                    <th>Tanggal Pengajuan/Revisi</th>
                    <th>Organisasi Pemerintah Daerah</th>
                    <th>Nama Aplikasi</th>
                    <th>Status Assessment</th>
                    <th>Jenis Pengajuan</th>
                    <th>Status Pengajuan</th>
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
                        <td>{{ $apk->permohonan ?? '-' }}</td>
                        <td>{{ $apk->opd->nama_opd ?? '-' }}</td>
                        <td>{{ $apk->nama }}</td>
                        <td>{{ $apk->status_label }}</td>
                        <td>{{ $apk->jenis_assessment == 'Pertama' ? 'Pengajuan Pertama' : 'Pengajuan Revisi' }}</td>
                        <td>
                            {{-- Khusus jika status adalah "batal", tampilkan prioritas teratas --}}
                            @if($apk->status === 'batal')
                                <span class="btn btn-danger btn-sm">Assessment ditolak</span>

                            {{-- Jika role user adalah Admin --}}
                            @elseif(Auth::user()->role == 'admin')
                                @if($apk->jenis_jawaban === null)
                                    <form action="{{ route('assessment.terima', $apk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Terima</button>
                                    </form>
                                    <form action="{{ route('assessment.revisi_tombol', $apk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">Revisi</button>
                                    </form>
                                    <form action="{{ route('assessment.tolak', $apk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @elseif($apk->jenis_jawaban == 'Diterima')
                                    <span class="btn btn-success btn-sm">Assessment diterima</span>
                                @elseif($apk->jenis_jawaban == 'Ditolak')
                                    <span class="btn btn-warning btn-sm">Assessment ditunda</span>
                                @endif
                            @endif
                        </td>

                        <td class="text-center">
                            @php
                                $routeName = 'admin.show-apk';
                            @endphp
                            <a href="{{ route($routeName, $apk->id) }}" title="Detail">
                                <i class="bx bxs-show" style="font-size: 1.5rem;"></i>
                            </a>
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
