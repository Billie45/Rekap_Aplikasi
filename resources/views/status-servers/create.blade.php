{{-- filepath: d:\File\xampp\htdocs\Rekap_aplikasi\resources\views\status-servers\create.blade.php --}}
@extends('layouts.app')

@section('content')
@include('components.template-form')
<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Tambah Status Server</h4>
<div class="container">
    <form action="{{ route('status-server.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Rekap Aplikasi (readonly) --}}
        <div class="mb-3">
            <label class="form-label">Rekap Aplikasi</label>
            <input type="text" class="form-control" value="{{ $penilaian->rekapAplikasi->nama ?? '-' }}" readonly>
            <input type="hidden" name="penilaian_id" value="{{ $penilaian->id }}">
            @error('penilaian_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Masuk Server --}}
        <div class="mb-3">
            <label for="tanggal_masuk_server" class="form-label">Tanggal Masuk Server</label>
            <input type="date" name="tanggal_masuk_server" id="tanggal_masuk_server" class="form-control" required value="{{ old('tanggal_masuk_server') }}">
            @error('tanggal_masuk_server')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status Server --}}
        <div class="mb-3">
            <label for="status_server" class="form-label">Status Server</label>
            <select name="status_server" id="status_server" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="development">Development</option>
                <option value="production">Production</option>
                <option value="luar">Luar</option>
            </select>
            @error('status_server')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Permohonan (PDF) --}}
        <div class="mb-3">
            <label for="permohonan" class="form-label">Permohonan (PDF)</label>
            <input type="file" name="permohonan" id="permohonan" class="form-control" accept="application/pdf">
            @error('permohonan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Dokumen Teknis (PDF) --}}
        <div class="mb-3">
            <label for="dokumen_teknis" class="form-label">Dokumen Teknis (PDF)</label>
            <input type="file" name="dokumen_teknis" id="dokumen_teknis" class="form-control" accept="application/pdf">
            @error('dokumen_teknis')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
