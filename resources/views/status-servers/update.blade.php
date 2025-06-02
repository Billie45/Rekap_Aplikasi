{{-- filepath: d:\File\xampp\htdocs\Rekap_aplikasi\resources\views\status-servers\update.blade.php --}}
@extends('layouts.app')

@section('content')
@include('components.template-form')
<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4 mt-4">Edit Status Server</h4>
<div class="container">
    <form action="{{ route('status-server.update', $statusServer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Rekap Aplikasi (readonly) --}}
        <div class="mb-3">
            <label class="form-label">Rekap Aplikasi</label>
            <input type="text" class="form-control" value="{{ $statusServer->penilaian->rekapAplikasi->nama ?? '-' }}" readonly>
        </div>

        {{-- Tanggal Masuk Server --}}
        <div class="mb-3">
            <label for="tanggal_masuk_server" class="form-label">Tanggal Masuk Server</label>
            <input type="date" name="tanggal_masuk_server" id="tanggal_masuk_server" class="form-control" required value="{{ old('tanggal_masuk_server', $statusServer->tanggal_masuk_server) }}">
            @error('tanggal_masuk_server')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status Server --}}
        <div class="mb-3">
            <label for="status_server" class="form-label">Status Server</label>
            <select name="status_server" id="status_server" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="development" {{ $statusServer->status_server == 'development' ? 'selected' : '' }}>Development</option>
                <option value="production" {{ $statusServer->status_server == 'production' ? 'selected' : '' }}>Production</option>
                <option value="luar" {{ $statusServer->status_server == 'luar' ? 'selected' : '' }}>Luar</option>
            </select>
            @error('status_server')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Permohonan (PDF) --}}
        <div class="mb-3">
            <label for="permohonan" class="form-label">Permohonan (PDF)</label>
            @if($statusServer->permohonan)
                <div>
                    <a href="{{ asset('storage/' . $statusServer->permohonan) }}" target="_blank">Lihat File Lama</a>
                </div>
            @endif
            <input type="file" name="permohonan" id="permohonan" class="form-control" accept="application/pdf">
            @error('permohonan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Dokumen Teknis (PDF) --}}
        <div class="mb-3">
            <label for="dokumen_teknis" class="form-label">Dokumen Teknis (PDF)</label>
            @if($statusServer->dokumen_teknis)
                <div>
                    <a href="{{ asset('storage/' . $statusServer->dokumen_teknis) }}" target="_blank">Lihat File Lama</a>
                </div>
            @endif
            <input type="file" name="dokumen_teknis" id="dokumen_teknis" class="form-control" accept="application/pdf">
            @error('dokumen_teknis')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
