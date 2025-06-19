<style>
    .custom-table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }

    .thead-default th {
        background-color: #1e3a8a; /* default biru */
        color: white;
        font-weight: 600;
        border: 1px solid #dee2e6;
    }

    .thead-opd th {
        background-color: #1f7a6b; /* hijau untuk OPD */
        color: white;
        font-weight: 600;
        border: 1px solid #dee2e6;
    }

    .custom-table td,
    .custom-table th {
        border: 1px solid #dee2e6;
        padding: 12px 16px;
        vertical-align: middle;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .custom-table tbody tr:hover {
        background-color: #e9ecef;
        transition: background-color 0.3s ease;
    }

    .table-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        margin-top: 2rem;
        color: #495057;
    }

    .w-col-text {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
    }

    .w-col-num {
        width: 60px;
        min-width: 60px;
        max-width: 60px;
        text-align: center;
    }
</style>

@if(auth()->user()->role == 'admin')
    <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">
        Rekap Aplikasi
    </h4>
@else
    <h4 class="section-title">
        <i class="bx bx-clipboard" style="color: #2d9a8c;"></i>
        Rekap Assessment Aplikasi
    </h4>
@endif

<div class="container">


    @if ($rekap && $rekap->updated_at)
        <p class="text-muted">
            <strong>Rekap update data S.D:</strong> {{ $rekap->updated_at->translatedFormat('l, d F Y H:i:s') }}
        </p>
    @else
        <p class="text-muted">
            <strong>Rekap update data S.D:</strong> -
        </p>
    @endif

    {{-- Tabel Jenis Pengajuan & Jenis Permohonan --}}
    @php
        $excludedStatus = ['diproses', 'perbaikan', 'prosesBA', 'batal'];

        $jenis_pengajuan = [
            'Website' => $aplikasis->where('tipe', 'web')->whereNotIn('status', $excludedStatus)->count(),
            'Aplikasi Web' => $aplikasis->where('tipe', 'apk')->whereNotIn('status', $excludedStatus)->count(),
        ];

        $jenis_permohonan = [
            'Baru' => $aplikasis->where('jenis', 'baru')->whereNotIn('status', $excludedStatus)->count(),
            'Pengembangan' => $aplikasis->where('jenis', 'pengembangan')->whereNotIn('status', $excludedStatus)->count(),
        ];

        $total_pengajuan = array_sum($jenis_pengajuan);
        $total_permohonan = array_sum($jenis_permohonan);
    @endphp

    <table class="table custom-table text-center align-middle">
        <thead class="{{ (in_array(Auth::user()->role, ['opd', 'user'])) ? 'thead-opd' : 'thead-default' }}">
            <tr>
                <th colspan="3">1. Jenis Pengajuan Aplikasi</th>
                <th colspan="3">2. Jenis Permohonan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="w-col-text">Website</td>
                <td class="w-col-num">{{ $jenis_pengajuan['Website'] }}</td>
                <td class="w-col-num" rowspan="2">{{ $total_pengajuan }}</td>
                <td class="w-col-text">Baru</td>
                <td class="w-col-num">{{ $jenis_permohonan['Baru'] }}</td>
                <td class="w-col-num" rowspan="2">{{ $total_permohonan }}</td>
            </tr>
            <tr>
                <td class="w-col-text">Aplikasi Web</td>
                <td class="w-col-num">{{ $jenis_pengajuan['Aplikasi Web'] }}</td>
                <td class="w-col-text">Pengembangan</td>
                <td class="w-col-num">{{ $jenis_permohonan['Pengembangan'] }}</td>
            </tr>
        </tbody>
    </table>


    {{-- Tabel Proses Assessment --}}
    @php
        $status_counts = [
            'assessment1' => $aplikasis->where('status', 'assessment1')->count(),
            'assessment2' => $aplikasis->where('status', 'assessment2')->count(),
            'development' => $aplikasis->where('status', 'development')->count(),
            'selesai' => $aplikasis->where('status', 'selesai')->count(),
        ];
        $total_status = array_sum($status_counts);
    @endphp

    <table class="table custom-table text-center align-middle">
        <thead class="{{ (in_array(Auth::user()->role, ['opd', 'user'])) ? 'thead-opd' : 'thead-default' }}">
            <tr>
                <th colspan="5">3. Proses Assessment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4">Assessment 1</td>
                <td>{{ $status_counts['assessment1'] }}</td>
            </tr>
            <tr>
                <td colspan="4">Assessment 2</td>
                <td>{{ $status_counts['assessment2'] }}</td>
            </tr>
            <tr>
                <td colspan="4">Development</td>
                <td>{{ $status_counts['development'] }}</td>
            </tr>
            <tr>
                <td colspan="4">Selesai</td>
                <td>{{ $status_counts['selesai'] }}</td>
            </tr>
            <tr class="fw-bold">
                <td colspan="4">Total</td>
                <td>{{ $total_status }}</td>
            </tr>
        </tbody>
    </table>

</div>
