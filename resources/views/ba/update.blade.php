@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Berita Acara: <strong>{{ $ba->penilaian->rekapAplikasi->nama }}</strong>
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

            <form action="{{ route('ba.update', $ba->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                       value="{{ old('tanggal_pelaksanaan', $ba->tanggal_pelaksanaan->format('Y-m-d')) }}"
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
                                Dokumen Berita Acara
                            </label>
                            @if($ba->dokumen_ba)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    <a href="{{ asset('storage/' . $ba->dokumen_ba) }}"
                                       target="_blank"
                                       class="text-decoration-none">
                                        Dokumen BA Saat Ini
                                    </a>
                                </div>
                            @endif
                            <div class="input-group">
                                <input type="file"
                                       name="dokumen_ba"
                                       id="dokumen_ba"
                                       class="form-control @error('dokumen_ba') is-invalid @enderror"
                                       accept="application/pdf">
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted mt-2">
                                <i class="fas fa-info-circle"></i>
                                Kosongkan jika tidak ingin mengubah dokumen. Format: PDF, Maksimal 2MB
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
                                      required>{{ old('ringkasan_hasil', $ba->ringkasan_hasil) }}</textarea>
                            @error('ringkasan_hasil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('ba.show', $ba->id) }}"
                        class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
