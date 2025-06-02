@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Pengajuan Revisi Penilaian: <strong>{{ $penilaian->rekapAplikasi->nama }}</strong>
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

            <form action="{{ route('penilaian.revisi-penilaian.store', $penilaian->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        {{-- Catatan Revisi --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="catatan_revisi">
                                Catatan Singkat <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_revisi"
                                    id="catatan_revisi"
                                    class="form-control @error('catatan_revisi') is-invalid @enderror"
                                    rows="5"
                                    required>{{ old('catatan_revisi') }}</textarea>
                            <small class="text-muted">
                                Jelaskan secara detail poin-poin yang perlu direvisi
                            </small>
                            @error('catatan_revisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen Revisi --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="dokumen_revisi">
                                Surat Perbaikan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="file"
                                       name="dokumen_revisi"
                                       id="dokumen_revisi"
                                       class="form-control @error('dokumen_revisi') is-invalid @enderror"
                                       accept="application/pdf"
                                       required>
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted">
                                Format: PDF, Maksimal 2MB
                            </small>
                            @error('dokumen_revisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen Laporan --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="dokumen_laporan">
                                Lampiran Perbaikan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="file"
                                       name="dokumen_laporan"
                                       id="dokumen_laporan"
                                       class="form-control @error('dokumen_laporan') is-invalid @enderror"
                                       accept="application/pdf"
                                       required>
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted">
                                Format: PDF, Maksimal 2MB
                            </small>
                            @error('dokumen_laporan')
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
                        Ajukan Revisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
