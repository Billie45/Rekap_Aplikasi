<!-- resources/views/undangan/create.blade.php -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $apk->nama }}</strong>
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('undangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="rekap_aplikasi_id" value="{{ $apk->id }}">

                <div class="form-group mb-3">
                    <label for="tanggal_undangan">Tanggal Undangan</label>
                    <input type="date" class="form-control @error('tanggal_undangan') is-invalid @enderror"
                        id="tanggal_undangan" name="tanggal_undangan" value="{{ old('tanggal_undangan') }}" required>
                    @error('tanggal_undangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="assessment_dokumentasi">Assessment Dokumentasi</label>
                    <input type="file" class="form-control @error('assessment_dokumentasi') is-invalid @enderror"
                        id="assessment_dokumentasi" name="assessment_dokumentasi">
                    @error('assessment_dokumentasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="catatan_assessment">Catatan Assessment</label>
                    <textarea class="form-control @error('catatan_assessment') is-invalid @enderror"
                        id="catatan_assessment" name="catatan_assessment" rows="3">{{ old('catatan_assessment') }}</textarea>
                    @error('catatan_assessment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="surat_rekomendasi">Surat Rekomendasi</label>
                    <input type="file" class="form-control @error('surat_rekomendasi') is-invalid @enderror"
                        id="surat_rekomendasi" name="surat_rekomendasi">
                    @error('surat_rekomendasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('rekap-aplikasi.show', $apk->id) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
