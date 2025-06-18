{{-- filepath: d:\File\xampp\htdocs\Rekap_aplikasi\resources\views\status-servers\create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-server me-2"></i>
                    Tambah Status Server untuk: <strong>{{ $penilaian->rekapAplikasi->nama }}</strong>
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

            <form action="{{ route('status-server.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="penilaian_id" value="{{ $penilaian->id }}">

                <div class="row">
                    <div class="col-md-6">
                        {{-- Nama Server --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="nama_server">
                                Nama Server <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text"
                                       name="nama_server"
                                       id="nama_server"
                                       class="form-control @error('nama_server') is-invalid @enderror"
                                       value="{{ old('nama_server') }}"
                                       required>
                                <span class="input-group-text">
                                    <i class="fas fa-server"></i>
                                </span>
                            </div>
                            @error('nama_server')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Masuk Server --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="tanggal_masuk_server">
                                Tanggal Masuk Server <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="date"
                                       name="tanggal_masuk_server"
                                       id="tanggal_masuk_server"
                                       class="form-control @error('tanggal_masuk_server') is-invalid @enderror"
                                       value="{{ old('tanggal_masuk_server') }}"
                                       required>
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                            </div>
                            @error('tanggal_masuk_server')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Server --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="status_server">
                                Server <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <select name="status_server"
                                        id="status_server"
                                        class="form-select @error('status_server') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="development" {{ old('status_server') == 'development' ? 'selected' : '' }}>Development</option>
                                    <option value="production" {{ old('status_server') == 'production' ? 'selected' : '' }}>Production</option>
                                    <option value="luar" {{ old('status_server') == 'luar' ? 'selected' : '' }}>Luar</option>
                                </select>
                                <span class="input-group-text">
                                    <i class="fas fa-tasks"></i>
                                </span>
                            </div>
                            @error('status_server')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        {{-- Permohonan --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="permohonan">
                                Dokumen Permohonan
                            </label>
                            <div class="input-group">
                                <input type="file"
                                       name="permohonan"
                                       id="permohonan"
                                       class="form-control @error('permohonan') is-invalid @enderror"
                                       accept="application/pdf">
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted mt-2">
                                <i class="fas fa-info-circle"></i>
                                Format: PDF, Maksimal 2MB
                            </small>
                            @error('permohonan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen Teknis --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="dokumen_teknis">
                                Dokumen Teknis
                            </label>
                            <div class="input-group">
                                <input type="file"
                                       name="dokumen_teknis"
                                       id="dokumen_teknis"
                                       class="form-control @error('dokumen_teknis') is-invalid @enderror"
                                       accept="application/pdf">
                                <span class="input-group-text">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                            </div>
                            <small class="text-muted mt-2">
                                <i class="fas fa-info-circle"></i>
                                Format: PDF, Maksimal 2MB
                            </small>
                            @error('dokumen_teknis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan Status Server
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
