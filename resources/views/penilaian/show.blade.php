@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">Detail Penilaian</h1>
                    <div>
                        @auth
                        @if(Auth::user()->role === 'admin')
                        {{-- <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a> --}}
                        @endif
                        @endauth
                        <a href="{{ route('rekap-aplikasi.show', $penilaian->rekap_aplikasi_id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Alert Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Main Content --}}
                <div class="row">
                    {{-- Basic Information --}}
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Informasi Penilaian
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Rekap Aplikasi:</label>
                                            <p class="mb-1">{{ $penilaian->rekapAplikasi->nama ?? 'N/A' }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Deadline Perbaikan:</label>
                                            <p class="mb-1">
                                                @if($penilaian->tanggal_deadline_perbaikan)
                                                    {{ \Carbon\Carbon::parse($penilaian->tanggal_deadline_perbaikan)->format('d F Y') }}
                                                    <small class="text-muted">
                                                        ({{ \Carbon\Carbon::parse($penilaian->tanggal_deadline_perbaikan)->diffForHumans() }})
                                                    </small>
                                                @else
                                                    <span class="text-muted">Tidak ditentukan</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Keputusan Assessment:</label>
                                            <p class="mb-1">
                                                @if($penilaian->keputusan_assessment)
                                                    @php
                                                        $badgeClass = match($penilaian->keputusan_assessment) {
                                                            'lulus_tanpa_revisi' => 'bg-success',
                                                            'lulus_dengan_revisi' => 'bg-warning',
                                                            'assessment_ulang' => 'bg-info',
                                                            'tidak_lulus' => 'bg-danger',
                                                            default => 'bg-secondary'
                                                        };

                                                        $statusText = match($penilaian->keputusan_assessment) {
                                                            'lulus_tanpa_revisi' => 'Lulus Tanpa Revisi',
                                                            'lulus_dengan_revisi' => 'Lulus Dengan Revisi',
                                                            'assessment_ulang' => 'Assessment Ulang',
                                                            'tidak_lulus' => 'Tidak Lulus',
                                                            default => $penilaian->keputusan_assessment
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }} fs-6">{{ $statusText }}</span>
                                                @else
                                                    <span class="text-muted">Belum ditentukan</span>
                                                @endif
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Dibuat:</label>
                                            <p class="mb-1">
                                                {{ $penilaian->created_at->format('d F Y, H:i') }}
                                                <small class="text-muted">
                                                    ({{ $penilaian->created_at->diffForHumans() }})
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Dokumen Assessment --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-pdf"></i> Dokumen Hasil Assessment
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($penilaian->dokumen_hasil_assessment)
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-file-pdf text-danger" style="font-size: 2rem;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ basename($penilaian->dokumen_hasil_assessment) }}</h6>
                                            <small class="text-muted">
                                                @if(Storage::exists('public/' . $penilaian->dokumen_hasil_assessment))
                                                    Ukuran: {{ number_format(Storage::size('public/' . $penilaian->dokumen_hasil_assessment) / 1024, 2) }} KB
                                                @endif
                                            </small>
                                        </div>
                                        <div>
                                            <a href="{{ asset('storage/' . $penilaian->dokumen_hasil_assessment) }}"
                                               target="_blank" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                            <a href="{{ asset('storage/' . $penilaian->dokumen_hasil_assessment) }}"
                                               download class="btn btn-success btn-sm">
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-file-pdf" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">Tidak ada dokumen assessment yang diupload</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Revisi Terakhir --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-history"></i> Revisi Terakhir
                                </h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $latestRevisi = $penilaian->revisiPenilaians()->latest()->first();
                                @endphp

                                @if($latestRevisi)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 200px">Tanggal Pengajuan</th>
                                                <td>{{ $latestRevisi->created_at->format('d F Y, H:i') }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Status</th>
                                                <td>
                                                    @php
                                                        $statusBadge = match($latestRevisi->status) {
                                                            'diajukan' => 'bg-warning',
                                                            'diproses' => 'bg-info',
                                                            'selesai' => 'bg-success',
                                                            default => 'bg-secondary'
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $statusBadge }}">
                                                        {{ Str::ucfirst($latestRevisi->status) }}
                                                    </span>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <th>Catatan Revisi</th>
                                                <td>{{ $latestRevisi->catatan_revisi ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Dokumen</th>
                                                <td>
                                                    @if($latestRevisi->dokumen_revisi)
                                                        <a href="{{ asset('storage/' . $latestRevisi->dokumen_revisi) }}"
                                                           target="_blank"
                                                           class="btn btn-sm btn-primary">
                                                        <i class="fas fa-file-pdf me-1"></i> Lihat Dokumen Revisi
                                                        </a>
                                                    @endif
                                                    @if($latestRevisi->dokumen_laporan)
                                                        <a href="{{ asset('storage/' . $latestRevisi->dokumen_laporan) }}"
                                                           target="_blank"
                                                           class="btn btn-sm btn-info ms-1">
                                                        <i class="fas fa-file-pdf me-1"></i> Lihat Dokumen Laporan
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-clipboard-list" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">Belum ada revisi yang diajukan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="col-md-4">
                        {{-- Quick Actions --}}

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-cogs"></i> Aksi Cepat
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($penilaian->ba)
                                    <a href="{{ route('ba.show', $penilaian->ba->id) }}" class="btn btn-success w-100">
                                        <i class="fas fa-file-signature"></i> Lihat Berita Acara
                                    </a>
                                @else
                                    <span class="btn btn-secondary w-100 disabled">
                                        <i class="fas fa-file-signature"></i> Berita Acara Belum Tersedia
                                    </span>
                                @endif
                                {{-- Tombol Revisi untuk OPD --}}
                                @auth
                                    @if(Auth::user()->role === 'opd')
                                        @if($penilaian->rekapAplikasi->status === 'prosesBA' && $penilaian->rekapAplikasi->jenis_jawaban === null)
                                            <a href="{{ route('penilaian.revisi-penilaian.create', $penilaian->id) }}"
                                               class="btn btn-warning w-100 mt-2">
                                                <i class="fas fa-edit me-2"></i> Revisi Penilaian
                                            </a>
                                        @elseif($penilaian->rekapAplikasi->status === 'prosesBA' && $penilaian->rekapAplikasi->jenis_jawaban === 'Diproses')
                                            <button class="btn btn-secondary w-100 mt-2" disabled>
                                                <i class="fas fa-clock me-2"></i> Menunggu Verifikasi Admin
                                            </button>
                                        @elseif($penilaian->rekapAplikasi->status === 'prosesBA' && $penilaian->rekapAplikasi->jenis_jawaban === 'Ditolak')
                                            @php
                                                $latestRevisi = $penilaian->revisiPenilaians()->latest()->first();
                                            @endphp
                                            @if($latestRevisi)
                                                <a href="{{ route('penilaian.revisi-penilaian.edit', [
                                                    'penilaian' => $penilaian->id,
                                                    'revisi_penilaian' => $latestRevisi->id
                                                ]) }}" class="btn btn-warning w-100 mt-2">
                                                    <i class="fas fa-edit me-2"></i> Revisi Penilaian
                                                </a>
                                            @endif
                                            @elseif($penilaian->rekapAplikasi->status === 'assessment2' && $penilaian->rekapAplikasi->jenis_jawaban === null)
                                                @php
                                                    $latestRevision = $penilaian->rekapAplikasi->riwayatRevisiAssessments()
                                                        ->orderByDesc('tanggal_pengajuan')
                                                        ->first();
                                                @endphp
                                                <a href="{{ route('assessment.revisi', $penilaian->rekapAplikasi->id) }}"
                                                class="btn btn-danger w-100 mt-2">
                                                    <i class="fas fa-sync-alt me-2"></i> Ajukan Assessment Ulang
                                                </a>
                                            @endif
                                    @elseif(Auth::user()->role === 'admin')
                                        @if ($penilaian->rekapAplikasi->status === 'prosesBA' && $penilaian->rekapAplikasi->jenis_jawaban === 'Diproses')
                                            <div class="d-grid gap-2 mt-2">
                                                <form action="{{ route('penilaian.revisi-penilaian.verdict', ['penilaian' => $penilaian->id, 'verdict' => 'terima']) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success w-100">
                                                        <i class="fas fa-check me-2"></i> Terima Revisi
                                                    </button>
                                                </form>

                                                <form action="{{ route('penilaian.revisi-penilaian.verdict', ['penilaian' => $penilaian->id, 'verdict' => 'tolak']) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger w-100">
                                                        <i class="fas fa-times me-2"></i> Tolak Revisi
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                            @auth
                            @if(Auth::user()->role === 'admin')
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    {{-- <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit Penilaian
                                    </a> --}}
                                    @if($penilaian->rekapAplikasi->status === 'prosesBA' && $penilaian->rekapAplikasi->jenis_jawaban === 'Diterima')
                                        <a href="{{ route('ba.create', ['penilaian_id' => $penilaian->id]) }}" class="btn btn-success w-100">
                                            <i class="fas fa-file-signature"></i> Buat Berita Acara
                                        </a>
                                    @endif
                                    @if($penilaian->rekapAplikasi->status === 'assessment2' && $penilaian->rekapAplikasi->jenis_jawaban === null)
                                        <button class="btn btn-secondary w-100 mt-2" disabled>
                                            <i class="fas fa-exclamation-circle me-2"></i> Belum Assessment Ulang
                                        </button>
                                    @endif

                                    <form action="{{ route('penilaian.destroy', $penilaian->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus penilaian ini? Data yang dihapus tidak dapat dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-trash"></i> Hapus Penilaian
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                            @endauth
                        </div>
                        {{-- Statistics --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-pie"></i> Statistik
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h4 class="text-primary mb-0">{{ $penilaian->penilaianFotos->count() }}</h4>
                                            <small class="text-muted">Foto</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-success mb-0">
                                            {{ $penilaian->dokumen_hasil_assessment ? '1' : '0' }}
                                        </h4>
                                        <small class="text-muted">Dokumen</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Foto Dokumentasi --}}
                @if($penilaian->penilaianFotos && $penilaian->penilaianFotos->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-images"></i> Foto Dokumentasi Assessment
                                <span class="badge bg-primary">{{ $penilaian->penilaianFotos->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($penilaian->penilaianFotos as $index => $foto)
                                    <div class="col-md-3 col-sm-6 mb-4">
                                        <div class="card shadow-sm">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $foto->foto) }}"
                                                     alt="Foto Dokumentasi {{ $index + 1 }}"
                                                     class="card-img-top"
                                                     style="height: 200px; object-fit: cover; cursor: pointer;"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#imageModal{{ $foto->id }}">

                                                {{-- Badge nomor foto --}}
                                                <span class="position-absolute top-0 start-0 badge bg-dark m-2">
                                                    {{ $index + 1 }}
                                                </span>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        {{ $foto->created_at->format('d/m/Y H:i') }}
                                                    </small>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ asset('storage/' . $foto->foto) }}"
                                                           target="_blank"
                                                           class="btn btn-outline-primary btn-sm"
                                                           title="Lihat full size">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @auth
                                                        @if(Auth::user()->role === 'admin')
                                                        <form action="{{ route('penilaian.foto.destroy', $foto->id) }}"
                                                              method="POST"
                                                              class="d-inline"
                                                              onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    title="Hapus foto">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Modal untuk preview foto --}}
                                        <div class="modal fade" id="imageModal{{ $foto->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Foto Dokumentasi {{ $index + 1 }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $foto->foto) }}"
                                                             alt="Foto Dokumentasi {{ $index + 1 }}"
                                                             class="img-fluid">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <small class="text-muted me-auto">
                                                            Diupload: {{ $foto->created_at->format('d F Y, H:i') }}
                                                        </small>
                                                        <a href="{{ asset('storage/' . $foto->foto) }}"
                                                           download
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fas fa-download"></i> Unduh
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-images"></i> Foto Dokumentasi Assessment
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-images" style="font-size: 4rem; opacity: 0.3;"></i>
                                <p class="mt-3 mb-0">Tidak ada foto dokumentasi yang diupload</p>
                                @auth
                                @if(Auth::user()->role === 'admin')
                                {{-- <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-plus"></i> Tambah Foto
                                </a> --}}
                                @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Custom CSS --}}
    <style>
        .card {
            transition: box-shadow 0.15s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.775rem;
        }

        .badge {
            font-size: 0.75em;
        }

        .img-fluid {
            max-height: 80vh;
        }
    </style>
@endsection
