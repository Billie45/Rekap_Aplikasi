@extends('layouts.app')

@section('content')
    @include('components.template-tabel')

    <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Manajemen Pengajuan Assessment Aplikasi</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper mt-3">
        <table class="compact-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Riwayat</th>
                    <th>Tanggal Pengajuan/Revisi</th>
                    <th>Organisasi Pemerintah Daerah</th>
                    <th>Nama Aplikasi</th>
                    <th>Status Assessment</th>
                    <th>Jenis Pengajuan</th>
                    {{-- <th>Status Pengajuan</th> --}}
                    <th>Status Pengajuan</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $apk)
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td class="text-center">
                            <button class="accordion-toggle" data-target="#accordion-{{ $apk->id }}" style="background:none;border:none;">
                                <i class="bx bx-chevron-down" style="font-size: 1.5rem;"></i>
                            </button>
                        </td>
                        <td>{{ $apk->permohonan ?? '-' }}</td>
                        <td>{{ $apk->opd->nama_opd ?? '-' }}</td>
                        <td>{{ $apk->nama }}</td>
                        <td>{{ $apk->status_label }}</td>
                        <td>{{ $apk->jenis_assessment == 'Pertama' ? 'Pengajuan Pertama' : 'Pengajuan Revisi' }}</td>
                        {{-- <td>
                            @if($apk->status != 'perbaikan' && $apk->status != 'diproses')
                                Diterima
                            @elseif($apk->status == 'perbaikan' && $apk->jenis_jawaban == 'Ditolak')
                                Perlu Perbaikan
                            @elseif($apk->status == 'perbaikan' || $apk->status == 'diproses' && $apk->jenis_jawaban === null)
                                Menunggu Verifikasi
                            @else
                                Diproses
                            @endif
                        </td> --}}
                        <td>
                            {{-- Khusus jika status adalah "batal", tampilkan prioritas teratas --}}
                            @if($apk->status === 'batal')
                                {{-- <span class="btn btn-danger btn-sm">Assessment ditolak</span> --}}
                            {{-- Jika role user adalah OPD --}}
                            @elseif(Auth::user()->role == 'opd')
                                @if($apk->jenis_jawaban === null && $apk->status == 'perbaikan' || $apk->jenis_jawaban === null)
                                    <span class="btn btn-danger btn-sm">Menunggu verifikasi admin</span>
                                @elseif($apk->jenis_jawaban == 'Diterima')
                                    <span class="btn btn-primary btn-sm">Assessment diterima</span>
                                @elseif($apk->jenis_jawaban == 'Ditolak')
                                    <form action="{{ route('assessment.revisi', $apk->id) }}" method="GET" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit">Ajukan Revisi</button>
                                    </form>
                                @endif
                            @endif
                            {{-- Jika role user adalah admin --}}
                        </td>

                        <td class="text-center">
                            @php
                                $routeName = Auth::user()->role === 'admin' ? 'admin.show-apk' : 'opd.show-apk';
                            @endphp
                            <a href="{{ route($routeName, $apk->id) }}" title="Detail">
                                <i class="bx bxs-show" style="font-size: 1.5rem;"></i>
                            </a>
                        </td>
                    </tr>
                    <tr id="accordion-{{ $apk->id }}" class="accordion-row" style="display: none; background: #f9fafb;">
                        <td colspan="9">
                            <div style="padding: 1rem;">
                                <strong>Assessment Terkini:</strong>
                                @php
                                    $riwayat = $apk->riwayatRevisiAssessments;
                                @endphp

                                @if($riwayat && $riwayat->count() > 0)
                                    {{-- Riwayat Terbaru (tampilkan semua data secara detail dalam 1 tabel) --}}
                                    @php
                                        $latest = $riwayat->first(); // ambil data terbaru
                                        $others = $riwayat->slice(1); // sisanya
                                    @endphp

                                    {{-- Tabel Detail Riwayat Terbaru --}}
                                    <table style="width: 100%; margin-bottom: 1rem; border-collapse: collapse;">
                                        <tbody>
                                            <tr><th style="text-align: left;">Tanggal Pengajuan</th><td>{{ $latest->tanggal_pengajuan ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Jenis</th><td>{{ $latest->jenis ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Nama</th><td>{{ $latest->nama ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Subdomain</th><td>
                                                    @if($latest->subdomain)
                                                        <a href="{{ $latest->subdomain }}" target="_blank">{{ $latest->subdomain }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td></tr>
                                            <tr><th style="text-align: left;">Tipe</th><td>{{ $latest->tipe ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Jenis Permohonan</th><td>{{ $latest->jenis_permohonan ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Link Dokumentasi</th><td>{{ $latest->link_dokumentasi ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Akun Link</th><td>
                                                    @if($latest->akun_link)
                                                        <a href="{{ $latest->akun_link }}" target="_blank">{{ $latest->akun_link }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td></tr>
                                            <tr><th style="text-align: left;">Akun Username</th><td>{{ $latest->akun_username ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Akun Password</th><td>{{ $latest->akun_password ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">CP OPD Nama</th><td>{{ $latest->cp_opd_nama ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">CP OPD No Telepon</th><td>{{ $latest->cp_opd_no_telepon ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">CP Pengembang Nama</th><td>{{ $latest->cp_pengembang_nama ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">CP Pengembang No Telepon</th><td>{{ $latest->cp_pengembang_no_telepon ?? '-' }}</td></tr>
                                            <tr>
                                                <th style="text-align: left;">Surat Permohonan</th>
                                                <td>
                                                    @if($latest->surat_permohonan)
                                                        <a href="{{ asset('storage/' . $latest->surat_permohonan) }}" target="_blank" title="Lihat PDF">
                                                            <i class='bx bxs-file-pdf' style="font-size: 1.5rem;"></i>
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr><th style="text-align: left;">Catatan</th><td>{{ $latest->catatan ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>

                                    {{-- Tabel Riwayat Lama --}}
                                    <strong>Assessment Lama:</strong>
                                    @if(count($others) > 0)
                                        @foreach($others as $rev)
                                            <table style="width: 100%; margin-bottom: 1rem; border-collapse: collapse; background: #fff;">
                                                <thead style="background: #e5e7eb;">
                                                    <tr>
                                                        <th style="text-align:left; width:20%;">Tanggal Pengajuan</th>
                                                        <th style="text-align:left; width:5%;">Surat</th>
                                                        <th style="text-align:left; width:75%;">Catatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $rev->tanggal_pengajuan ?? '-' }}</td>
                                                        <td>
                                                            @if($rev->surat_permohonan)
                                                                <a href="{{ asset('storage/' . $rev->surat_permohonan) }}" target="_blank" title="Lihat PDF">
                                                                    <i class='bx bxs-file-pdf' style="font-size: 1.5rem;"></i>
                                                                </a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>{{ $rev->catatan ?? '-' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                    @endif

                                @else
                                    <em>Tidak ada riwayat revisi.</em>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('.revisi-button').click(function() {
                var apkId = $(this).data('id');
                $('#revisiForm').attr('action', '/assessment/revisi_tombol/' + apkId);
                $('#rekap_aplikasi_id').val(apkId);
            });

            // Accordion toggle
            $('.accordion-toggle').click(function() {
                var target = $(this).data('target');
                $(target).toggle();
                // Optional: toggle arrow direction
                $(this).find('i').toggleClass('bx-chevron-down bx-chevron-up');
            });
        });
    </script>
@endsection
