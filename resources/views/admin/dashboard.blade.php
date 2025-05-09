@extends('layouts.app')

@section('content')
    {{-- <h1>Halaman Dashboard Admin</h1> --}}

        {{-- <div class="card-body d-flex justify-content-center gap-4">

            <a href="{{ route('admin.list-apk') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
                Daftar Aplikasi
            </a>
            <a href="/rekap-aplikasi" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
                Daftar Pengajuan Assessment
            </a>
            <a href="{{ route('admin.edit-role') }}" class="btn btn-light btn-lg px-5 py-5 rounded-4 shadow border fs-3">
                Kelola Akun
            </a>
        </div> --}}

        @include('components.rekap-assessment-1', ['aplikasis' => $aplikasis])
@endsection


