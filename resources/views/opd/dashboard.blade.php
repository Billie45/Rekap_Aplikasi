@extends('layouts.app')

@section('content')
@include('components.template-tabel')

<style>
    .dashboard-container {
        background: linear-gradient(135deg, #dbf5f0 0%, #a4e5e0 100%);
        min-height: 100vh;
        padding: 20px 0;
        position: relative;
        overflow: hidden;
    }

    .dashboard-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/><circle cx="900" cy="800" r="80" fill="url(%23a)"/></svg>');
        opacity: 0.3;
        pointer-events: none;
    }

    .welcome-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .welcome-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: rotate(45deg);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #2d9a8c, #1f7a6b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        text-align: center;
    }

    .welcome-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        text-align: center;
        margin-bottom: 0;
    }

    .card-modern {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2d9a8c, #1b8a7a, #16b3a0);
        border-radius: 20px 20px 0 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 30px;
        background: linear-gradient(135deg, #2d9a8c, #1f7a6b);
        border-radius: 2px;
    }

    .table-modern {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
    }

    .table-modern thead th {
        background: linear-gradient(135deg, #1f7a6b, #1f7a6b);
        color: white;
        font-weight: 600;
        padding: 15px;
        border: none;
        text-align: center;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background: linear-gradient(135deg, rgba(45, 154, 140, 0.05), rgba(31, 122, 107, 0.05));
        transform: scale(1.01);
    }

    .table-modern tbody td {
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .btn-action {
        background: linear-gradient(135deg, #2d9a8c, #1f7a6b);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 8px 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(45, 154, 140, 0.3);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(45, 154, 140, 0.4);
        color: white;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-approved {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .status-pending {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
        color: white;
    }

    .status-rejected {
        background: linear-gradient(135deg, #f56565, #e53e3e);
        color: white;
    }

    .icon-link {
        transition: all 0.3s ease;
        display: inline-block;
    }

    .icon-link:hover {
        transform: scale(1.2);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
        font-style: italic;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #2d9a8c, #1f7a6b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-label {
        color: #6c757d;
        font-weight: 500;
        margin-top: 5px;
    }
</style>

<div class="dashboard-container">
    <div class="container">
        <!-- Welcome Header -->
        <div class="welcome-header">
            <h1 class="welcome-title">Dashboard Assessment OPD</h1>
            <p class="welcome-subtitle">Selamat datang di sistem pengelolaan assessment aplikasi</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            @php
                $opdId = Auth::user()->opd_id;
                $totalAplikasi = \App\Models\RekapAplikasi::where('opd_id', $opdId)->count();
                $totalUndangan = \App\Models\RekapAplikasi::where('opd_id', $opdId)->with('undangan')->get()->pluck('undangan')->flatten()->count();
                $totalPenilaian = \App\Models\Penilaian::whereHas('rekapAplikasi', function($query) use ($opdId) { $query->where('opd_id', $opdId); })->count();
            @endphp

            <div class="stat-card">
                <div class="stat-number">{{ $totalAplikasi }}</div>
                <div class="stat-label">Total Aplikasi</div>
            </div>

            <div class="stat-card">
                <div class="stat-number">{{ $totalUndangan }}</div>
                <div class="stat-label">Total Undangan</div>
            </div>

            <div class="stat-card">
                <div class="stat-number">{{ $totalPenilaian }}</div>
                <div class="stat-label">Total Penilaian</div>
            </div>
        </div>

        <!-- Rekap Assessment -->
        <div class="card-modern">
            @include('components.rekap-assessment-1', ['aplikasis' => $aplikasis])
        </div>

        <!-- Tabel Undangan -->
        <div class="card-modern">
            <h4 class="section-title">
                <i class="bx bx-calendar" style="color: #2d9a8c;"></i>
                Daftar Undangan Assessment
            </h4>
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Aplikasi</th>
                            <th>Surat Undangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Tempat</th>
                            <th>Link Zoom</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $aplikasis = \App\Models\RekapAplikasi::where('opd_id', $opdId)
                                ->with('undangan')
                                ->orderBy('created_at', 'desc')
                                ->get();
                        @endphp
                        @forelse ($aplikasis->pluck('undangan')->flatten() as $index => $undangan)
                            <tr>
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td><strong>{{ $undangan->rekapAplikasi->nama }}</strong></td>
                                <td class="text-center">
                                    @if ($undangan->surat_undangan)
                                        <a href="{{ asset('storage/' . $undangan->surat_undangan) }}" target="_blank"
                                           class="icon-link" title="Lihat Dokumen">
                                            <i class="bx bxs-file-pdf" style="font-size: 1.8rem; color: #e53e3e;"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $undangan->tanggal_zoom_meeting ?? '-' }}</td>
                                <td>{{ $undangan->waktu_zoom_meeting ?? '-' }}</td>
                                <td>{{ $undangan->tempat ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($undangan->link_zoom_meeting)
                                        <a href="{{ $undangan->link_zoom_meeting }}" target="_blank"
                                           class="icon-link" title="Join Zoom Meeting">
                                            <i class="bx bxs-video" style="font-size: 1.8rem; color: #2d9a8c;"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="bx bx-inbox" style="font-size: 3rem; margin-bottom: 10px; display: block;"></i>
                                    Belum ada data undangan assessment
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Penilaian -->
        <div class="card-modern">
            <h4 class="section-title">
                <i class="bx bx-clipboard" style="color: #2d9a8c;"></i>
                Daftar Penilaian Assessment
            </h4>
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Aplikasi</th>
                            <th>Keputusan Assessment</th>
                            <th>Tanggal Deadline</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $penilaians = \App\Models\Penilaian::whereHas('rekapAplikasi', function($query) use ($opdId) {
                                $query->where('opd_id', $opdId);
                            })->orderBy('created_at', 'desc')->get();
                        @endphp
                        @forelse ($penilaians as $index => $penilaian)
                            <tr>
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td><strong>{{ $penilaian->rekapAplikasi->nama }}</strong></td>
                                <td>
                                    @php
                                        $keputusan = str_replace('_', ' ', ucwords($penilaian->keputusan_assessment));
                                        $statusClass = 'status-pending';
                                        if (stripos($keputusan, 'approve') !== false || stripos($keputusan, 'terima') !== false) {
                                            $statusClass = 'status-approved';
                                        } elseif (stripos($keputusan, 'reject') !== false || stripos($keputusan, 'tolak') !== false) {
                                            $statusClass = 'status-rejected';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $keputusan }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($penilaian->tanggal_deadline_perbaikan)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-action" title="Lihat Detail">
                                        <i class="bx bx-show"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="bx bx-clipboard" style="font-size: 3rem; margin-bottom: 10px; display: block;"></i>
                                    Belum ada data penilaian assessment
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
