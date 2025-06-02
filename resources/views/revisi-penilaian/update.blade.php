@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Revisi Penilaian: <strong>{{ $revisiPenilaian->penilaian->rekapAplikasi->nama }}</strong>
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

            <form action="{{ route('penilaian.revisi-penilaian.update', ['penilaian' => $revisiPenilaian->penilaian_id, 'revisi_penilaian' => $revisiPenilaian->id]) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                    required>{{ old('catatan_revisi', $revisiPenilaian->catatan_revisi) }}</textarea>
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
                                Surat Perbaikan
                            </label>
                            @if($revisiPenilaian->dokumen_revisi)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    <a href="{{ asset('storage/' . $revisiPenilaian->dokumen_revisi) }}"
                                       target="_blank"
                                       class="text-decoration-none">
                                        Dokumen Revisi Saat Ini
                                    </a>
                                </div>
                            @endif
                            <div class="input-group">
                                <input type="file"
                                       name="dokumen_revisi"
                                       id="dokumen_revisi"
                                       class="form-control @error('dokumen_revisi') is-invalid @enderror"
                                       accept="application/pdf">
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengubah dokumen. Format: PDF, Maksimal 2MB
                            </small>
                            @error('dokumen_revisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen Laporan --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="dokumen_laporan">
                                Lampiran Perbaikan
                            </label>
                            @if($revisiPenilaian->dokumen_laporan)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    <a href="{{ asset('storage/' . $revisiPenilaian->dokumen_laporan) }}"
                                       target="_blank"
                                       class="text-decoration-none">
                                        Dokumen Laporan Saat Ini
                                    </a>
                                </div>
                            @endif
                            <div class="input-group">
                                <input type="file"
                                       name="dokumen_laporan"
                                       id="dokumen_laporan"
                                       class="form-control @error('dokumen_laporan') is-invalid @enderror"
                                       accept="application/pdf">
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengubah dokumen. Format: PDF, Maksimal 2MB
                            </small>
                            @error('dokumen_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Revisi --}}
                        {{-- <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="status">
                                Status Revisi <span class="text-danger">*</span>
                            </label>
                            <select name="status"
                                    id="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>
                                <option value="diajukan" {{ old('status', $revisiPenilaian->status) == 'diajukan' ? 'selected' : '' }}>
                                    Diajukan
                                </option>
                                <option value="diproses" {{ old('status', $revisiPenilaian->status) == 'diproses' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="selesai" {{ old('status', $revisiPenilaian->status) == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('penilaian.revisi-penilaian.show', ['penilaian' => $revisiPenilaian->penilaian_id, 'revisi_penilaian' => $revisiPenilaian->id]) }}"
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
