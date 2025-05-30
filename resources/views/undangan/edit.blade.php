@extends('layouts.app')
@section('content')

<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $apk->nama }}</strong>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('undangan.update', $undangan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tanggal_assessment" class="form-label fw-bold">Tanggal Assessment</label>
                    <input type="date" class="form-control @error('tanggal_assessment') is-invalid @enderror"
                        id="tanggal_assessment" name="tanggal_assessment" value="{{ old('tanggal_assessment', $undangan->tanggal_assessment) }}" required>
                    @error('tanggal_assessment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="surat_undangan" class="form-label fw-bold">Surat Undangan (PDF)</label>
                    @if($undangan->surat_undangan)
                        <p class="text-muted">File saat ini:
                            <a href="{{ asset('storage/' . $undangan->surat_undangan) }}" target="_blank" class="text-primary" accept="application/pdf>
                                <i class="fas fa-file-pdf"></i> Lihat Dokumen
                            </a>
                        </p>
                    @endif
                    <input type="file" class="form-control @error('surat_undangan') is-invalid @enderror"
                        id="surat_undangan" name="surat_undangan" accept=".pdf,.doc,.docx">
                    @error('surat_undangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="link_zoom_meeting" class="form-label fw-bold">Link Zoom Meeting</label>
                    <input type="url" class="form-control @error('link_zoom_meeting') is-invalid @enderror"
                        id="link_zoom_meeting" name="link_zoom_meeting" value="{{ old('link_zoom_meeting', $undangan->link_zoom_meeting) }}">
                    @error('link_zoom_meeting')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_zoom_meeting" class="form-label fw-bold">Tanggal Zoom Meeting</label>
                    <input type="date" class="form-control @error('tanggal_zoom_meeting') is-invalid @enderror"
                        id="tanggal_zoom_meeting" name="tanggal_zoom_meeting" value="{{ old('tanggal_zoom_meeting', $undangan->tanggal_zoom_meeting) }}">
                    @error('tanggal_zoom_meeting')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Waktu Zoom Meeting</label>
                    <div class="d-flex gap-2">
                        <input type="time" id="start_time" class="form-control" required>
                        <span class="align-self-center">sampai</span>
                        <input type="time" id="end_time" class="form-control" required>
                    </div>

                    <!-- Hidden input to store combined string -->
                    <input type="hidden" name="waktu_zoom_meeting" id="waktu_zoom_meeting"
                        value="{{ old('waktu_zoom_meeting') }}">

                    @error('waktu_zoom_meeting')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tempat" class="form-label fw-bold">Tempat</label>
                    <input type="text" class="form-control @error('tempat') is-invalid @enderror"
                        id="tempat" name="tempat" value="{{ old('tempat', $undangan->tempat) }}">
                    @error('tempat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('rekap-aplikasi.show', $apk->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .form-control {
        border-radius: 5px;
    }
    .btn {
        border-radius: 5px;
        padding: 8px 20px;
    }
</style>

<script>
    const startInput = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');
    const hiddenInput = document.getElementById('waktu_zoom_meeting');

    function updateZoomTime() {
        if (startInput.value && endInput.value) {
            // Ubah format dari HH:MM menjadi 10.00
            const startFormatted = startInput.value.replace(':', '.');
            const endFormatted = endInput.value.replace(':', '.');
            hiddenInput.value = `${startFormatted}-${endFormatted}`;
        }
    }

    startInput.addEventListener('change', updateZoomTime);
    endInput.addEventListener('change', updateZoomTime);
</script>
@endsection
