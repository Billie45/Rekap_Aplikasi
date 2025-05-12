@extends('layouts.app')

@section('content')

@include('components.template-tabel')

    <div class="table-wrapper mt-3">

        @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif

        <table class="compact-table">
            <thead>
                <tr>
                    <th>Nama Pengajuan</th>
                    <th>OPD yang Diajukan</th>
                    <th>Status Pengajuan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuans as $pengajuan)
                    <tr>
                        <td>{{ $pengajuan->name }}</td>
                        <td>{{ $pengajuan->opd ? $pengajuan->opd->nama_opd : 'N/A' }}</td>
                        <td>{{ $pengajuan->status_pengajuan }}</td>
                        <td>
                            @if($pengajuan->status_pengajuan == 'pending')
                                <form action="{{ route('admin.pengajuan-opd.approve', $pengajuan->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" style="color: blue">Approve</button>
                                </form>
                                <form action="{{ route('admin.pengajuan-opd.reject', $pengajuan->id) }}" method="POST" style="display:inline-block; margin-left: 5px;">
                                    @csrf
                                    <button type="submit" style="color: red" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">Reject</button>
                                </form>
                            @else
                                <span>Sudah Disetujui</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
