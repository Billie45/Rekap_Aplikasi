@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        {{-- Main Content --}}
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>
                            Detail Berita Acara
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- BA Details --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Informasi Aplikasi</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-light" style="width: 200px;">Nama Aplikasi</th>
                                <td>{{ $ba->penilaian->rekapAplikasi->nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">OPD</th>
                                <td>{{ $ba->penilaian->rekapAplikasi->opd->nama_opd }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal Pelaksanaan</th>
                                <td>{{ $ba->tanggal_pelaksanaan->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Ringkasan Hasil --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Ringkasan Hasil Assessment</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($ba->ringkasan_hasil)) !!}
                        </div>
                    </div>

                    {{-- Dokumen BA --}}
                    @if($ba->dokumen_ba)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Dokumen Berita Acara</h6>
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $ba->dokumen_ba) }}"
                                   target="_blank"
                                   class="text-decoration-none">
                                    Lihat Dokumen Berita Acara
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @auth
        @if(Auth::user()->role === 'admin')
        {{-- Sidebar --}}
        <div class="col-md-4">
            {{-- Quick Actions --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Aksi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('ba.edit', $ba->id) }}"
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit Berita Acara
                        </a>
                        <form action="{{ route('ba.destroy', $ba->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus berita acara ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                Hapus Berita Acara
                            </button>
                        </form>
                        <a href="{{ route('penilaian.show', $ba->penilaian_id) }}"
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Penilaian
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @endauth

            {{-- Metadata --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <small class="text-muted">Dibuat pada:</small><br>
                            {{ $ba->created_at->format('d F Y H:i') }}
                        </li>
                        <li>
                            <small class="text-muted">Terakhir diperbarui:</small><br>
                            {{ $ba->updated_at->format('d F Y H:i') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
