{{-- filepath: d:\File\xampp\htdocs\Rekap_aplikasi\resources\views\status-servers\show.blade.php --}}
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
                            <i class="fas fa-server me-2"></i>
                            Detail Status Server
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Status Server Details --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Informasi Aplikasi</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-light" style="width: 200px;">Rekap Aplikasi</th>
                                <td>{{ $statusServer->penilaian->rekapAplikasi->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal Masuk Server</th>
                                <td>{{ \Carbon\Carbon::parse($statusServer->tanggal_masuk_server)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Status Server</th>
                                <td>
                                    <span class="badge {{ $statusServer->status_server == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($statusServer->status_server) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Document Files --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Dokumen</h6>

                        <div class="p-3 bg-light rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    Permohonan
                                </div>
                                @if($statusServer->permohonan)
                                    <a href="{{ asset('storage/' . $statusServer->permohonan) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-1"></i>
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    Dokumen Teknis
                                </div>
                                @if($statusServer->dokumen_teknis)
                                    <a href="{{ asset('storage/' . $statusServer->dokumen_teknis) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-1"></i>
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                        <a href="{{ route('status-server.edit', $statusServer->id) }}"
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit Status Server
                        </a>
                        <a href="{{ url()->previous() }}"
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

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
                            {{ $statusServer->created_at->format('d F Y H:i') }}
                        </li>
                        <li>
                            <small class="text-muted">Terakhir diperbarui:</small><br>
                            {{ $statusServer->updated_at->format('d F Y H:i') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
