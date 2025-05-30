@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-signature me-2"></i>
                    Buat Berita Acara untuk: <strong>{{ $penilaian->rekapAplikasi->nama }}</strong>
                </h5>
            </div>
        </div>

        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ba.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="penilaian_id" value="{{ $penilaian->id }}">

                <div class="row">
                    <div class="col-md-6">
                        {{-- Tanggal Pelaksanaan --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="tanggal_pelaksanaan">
                                Tanggal Pelaksanaan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="date"
                                       name="tanggal_pelaksanaan"
                                       id="tanggal_pelaksanaan"
                                       class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                                       value="{{ old('tanggal_pelaksanaan') }}"
                                       required>
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                            </div>
                            @error('tanggal_pelaksanaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen BA --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="dokumen_ba">
                                Dokumen Berita Acara <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="file"
                                       name="dokumen_ba"
                                       id="dokumen_ba"
                                       class="form-control @error('dokumen_ba') is-invalid @enderror"
                                       accept="application/pdf"
                                       required>
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted mt-2">
                                <i class="fas fa-info-circle"></i>
                                Format: PDF, Maksimal 2MB
                            </small>
                            @error('dokumen_ba')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        {{-- Ringkasan Hasil --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="ringkasan_hasil">
                                Ringkasan Hasil Assessment <span class="text-danger">*</span>
                            </label>
                            <textarea name="ringkasan_hasil"
                                      id="ringkasan_hasil"
                                      class="form-control @error('ringkasan_hasil') is-invalid @enderror"
                                      rows="6"
                                      required>{{ old('ringkasan_hasil') }}</textarea>
                            @error('ringkasan_hasil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('penilaian.show', $penilaian->id) }}"
                        class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan Berita Acara
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
