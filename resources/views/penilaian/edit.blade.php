@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-edit me-2"></i>
                    Edit Penilaian Aplikasi: <strong>{{ $rekapAplikasi->nama }}</strong>
                </h5>
            </div>
        </div>

        <div class="card-body p-4">
            {{-- Alert Messages --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Left Column --}}
                    <div class="col-md-6">
                        {{-- Rekap Aplikasi --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Rekap Aplikasi</label>
                            <input type="text" class="form-control bg-light" value="{{ $rekapAplikasi->nama }}" readonly>
                        </div>

                        {{-- Dokumen Assessment --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="dokumen_hasil_assessment">
                                Dokumen Hasil Assessment
                            </label>

                            {{-- Show current document if exists --}}
                            @if($penilaian->dokumen_hasil_assessment)
                                <div class="alert alert-info mb-2">
                                    <i class="bx bxs-file-pdf me-2"></i>
                                    Dokumen saat ini:
                                    <a href="{{ asset('storage/' . $penilaian->dokumen_hasil_assessment) }}" target="_blank" class="alert-link">
                                        Lihat Dokumen
                                    </a>
                                </div>
                            @endif

                            <div class="input-group">
                                <input type="file" name="dokumen_hasil_assessment" id="dokumen_hasil_assessment"
                                    class="form-control @error('dokumen_hasil_assessment') is-invalid @enderror"
                                    accept="application/pdf">
                                <span class="input-group-text"><i class="bx bxs-file-pdf"></i></span>
                            </div>
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah dokumen</small>
                            @error('dokumen_hasil_assessment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Deadline --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="tanggal_deadline_perbaikan">
                                Tanggal Deadline Perbaikan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="date" name="tanggal_deadline_perbaikan" id="tanggal_deadline_perbaikan"
                                    class="form-control @error('tanggal_deadline_perbaikan') is-invalid @enderror"
                                    value="{{ old('tanggal_deadline_perbaikan', \Carbon\Carbon::parse($penilaian->tanggal_deadline_perbaikan)->format('Y-m-d')) }}">
                                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            </div>
                            @error('tanggal_deadline_perbaikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-md-6">
                        {{-- Keputusan Assessment --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="keputusan_assessment">
                                Keputusan Assessment <span class="text-danger">*</span>
                            </label>
                            <select name="keputusan_assessment" id="keputusan_assessment"
                                class="form-select @error('keputusan_assessment') is-invalid @enderror" required>
                                <option value="">-- Pilih Keputusan --</option>
                                <option value="lulus_tanpa_revisi" {{ old('keputusan_assessment', $penilaian->keputusan_assessment) == 'lulus_tanpa_revisi' ? 'selected' : '' }}>
                                    ✅ Lulus Tanpa Revisi
                                </option>
                                <option value="lulus_dengan_revisi" {{ old('keputusan_assessment', $penilaian->keputusan_assessment) == 'lulus_dengan_revisi' ? 'selected' : '' }}>
                                    📝 Lulus Dengan Revisi
                                </option>
                                <option value="assessment_ulang" {{ old('keputusan_assessment', $penilaian->keputusan_assessment) == 'assessment_ulang' ? 'selected' : '' }}>
                                    🔄 Assessment Ulang
                                </option>
                                <option value="tidak_lulus" {{ old('keputusan_assessment', $penilaian->keputusan_assessment) == 'tidak_lulus' ? 'selected' : '' }}>
                                    ❌ Tidak Lulus
                                </option>
                            </select>
                            @error('keputusan_assessment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Foto Dokumentasi Baru --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold" for="fotos">
                                Tambah Foto Dokumentasi Assessment
                            </label>
                            <div class="input-group">
                                <input type="file" name="fotos[]" id="fotos"
                                    class="form-control @error('fotos.*') is-invalid @enderror"
                                    multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/svg">
                                <span class="input-group-text"><i class="bx bx-images"></i></span>
                            </div>
                            <small class="text-muted mt-2">
                                <i class="bx bx-info-circle"></i>
                                Format: JPG, PNG, GIF, SVG. Pilih foto baru untuk ditambahkan.
                            </small>
                            @error('fotos.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="preview" class="mt-3 row g-2"></div>
                        </div>
                    </div>
                </div>

                {{-- Foto Dokumentasi Yang Sudah Ada --}}
                {{-- @if($penilaian->penilaianFotos && $penilaian->penilaianFotos->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold mb-3">
                            <i class="bx bx-photo-album me-2"></i>
                            Foto Dokumentasi Saat Ini
                        </h6>
                        <div class="row g-3">
                            @foreach($penilaian->penilaianFotos as $foto)
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $foto->foto) }}"
                                         class="card-img-top"
                                         style="height: 150px; object-fit: cover;"
                                         alt="Foto Dokumentasi">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                {{ basename($foto->foto) }}
                                            </small>
                                            <form action="{{ route('penilaian.foto.destroy', $foto->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif --}}

                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('rekap-aplikasi.show', $rekapAplikasi->id) }}"
                        class="btn btn-secondary">
                        <i class="bx bx-x-circle me-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="bx bx-save me-2"></i>
                        Update Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript for image preview --}}
<script>
document.getElementById('fotos').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    const files = e.target.files;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-3';
                div.innerHTML = `
                    <div class="card border-success">
                        <div class="card-header bg-success text-white p-1">
                            <small>Baru</small>
                        </div>
                        <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2">
                            <small class="text-muted">${file.name}</small>
                        </div>
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endsection
