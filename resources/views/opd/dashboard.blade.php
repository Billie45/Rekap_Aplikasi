@extends('layouts.app')

@section('content')
    {{-- <h1>Halaman Dashboard OPD</h1> --}}

    {{-- <div class="d-flex justify-content-center gap-4 my-4">
        <a href="{{ route('opd.form-pengajuan-assessment') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
            Tambah Pengajuan Assessment
        </a>
        <a href="{{ route('opd.daftar-pengajuan-assessment') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
            Daftar Pengajuan Assessment
        </a>
    </div> --}}

    @include('components.rekap-assessment-1', ['aplikasis' => $aplikasis])
    
@endsection
