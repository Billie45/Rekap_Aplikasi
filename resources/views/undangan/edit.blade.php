<!-- resources/views/undangan/edit.blade.php -->
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Undangan</h2>
    <h4>Aplikasi: {{ $apk->nama }}</h4>

    <form action="{{ route('undangan.update', $undangan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="tanggal_undangan">Tanggal Undangan</label>
            <input type="date" class="form-control @error('tanggal_undangan') is-invalid @enderror"
                id="tanggal_undangan" name="tanggal_undangan" value="{{ old('tanggal_undangan', $undangan->tanggal_undangan) }}" required>
            @error('tanggal_undangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="assessment_dokumentasi">Assessment Dokumentasi</label>
            @if($undangan->assessment_dokumentasi)
                <p>File saat ini: <a href="{{ asset('storage/' . $undangan->assessment_dokumentasi) }}" target="_blank">Lihat</a></p>
            @endif
            <input type="file" class="form-control @error('assessment_dokumentasi') is-invalid @enderror"
                id="assessment_dokumentasi" name="assessment_dokumentasi">
            @error('assessment_dokumentasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="catatan_assessment">Catatan Assessment</label>
            <textarea class="form-control @error('catatan_assessment') is-invalid @enderror"
                id="catatan_assessment" name="catatan_assessment" rows="3">{{ old('catatan_assessment', $undangan->catatan_assessment) }}</textarea>
            @error('catatan_assessment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="surat_rekomendasi">Surat Rekomendasi</label>
            @if($undangan->surat_rekomendasi)
                <p>File saat ini: <a href="{{ asset('storage/' . $undangan->surat_rekomendasi) }}" target="_blank">Lihat</a></p>
            @endif
            <input type="file" class="form-control @error('surat_rekomendasi') is-invalid @enderror"
                id="surat_rekomendasi" name="surat_rekomendasi">
            @error('surat_rekomendasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('rekap-aplikasi.show', $apk->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
