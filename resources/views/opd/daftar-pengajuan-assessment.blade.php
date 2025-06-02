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
                            @if($apk->status === 'diproses')
                                {{-- <span class="btn btn-danger btn-sm">Assessment ditolak</span> --}}
                            @elseif(Auth::user()->role == 'opd')
                                @if(is_null($apk->jenis_jawaban) && ($apk->status === 'assessment1' || $apk->status === 'perbaikan') || ($apk->jenis_jawaban == 'Diproses' && $apk->status === 'assessment2'))
                                    <span class="btn btn-secondary btn-sm">Menunggu Verifikasi</span>
                                    <button class="btn btn-secondary btn-sm"><i class='bx bx-bell'></i></button>
                                @elseif($apk->jenis_jawaban == 'Diterima' && ($apk->status == 'assessment1' || $apk->status == 'assessment2' || $apk->status == 'development'))
                                    <span class="btn btn-secondary btn-sm">Menunggu Penilaian</span>
                                    <button class="btn btn-secondary btn-sm"><i class='bx bx-bell'></i></button>
                                @elseif($apk->status == 'prosesBA' || $apk->status == 'batal' || $apk->status == 'selesai' || ($apk->status == 'assessment2' && $apk->jenis_jawaban == null))
                                    @if($apk->latestPenilaian)
                                        <a href="{{ route('penilaian.show', $apk->latestPenilaian->id) }}" class="btn btn-sm" style="background-color: #28a745; color: white;">Lihat Penilaian</a>
                                        @if(($apk->status == 'prosesBA' && ($apk->jenis_jawaban == 'Ditolak' || $apk->jenis_jawaban == null)) || ($apk->status == 'assessment2' && ($apk->jenis_jawaban == 'Ditolak' || $apk->jenis_jawaban == null)))
                                            <button class="btn btn-warning btn-sm"><i class='bx bx-bell'></i></button>
                                        @elseif(($apk->status == 'selesai') || ($apk->status == 'batal') || ($apk->status == 'prosesBA' && ($apk->jenis_jawaban == 'Diterima' || $apk->jenis_jawaban == 'Diproses')))
                                            <button class="btn btn-secondary btn-sm"><i class='bx bx-bell'></i></button>
                                        @endif
                                    @endif
                                @elseif($apk->jenis_jawaban == 'Ditolak' && ($apk->status == 'assessment1' || $apk->status == 'assessment2' || $apk->status === 'perbaikan'))
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#assessmentDitolakModal{{ $apk->id }}">Assessment ditolak</button>
                                    <button class="btn btn-warning btn-sm"><i class='bx bx-bell'></i></button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="assessmentDitolakModal{{ $apk->id }}" tabindex="-1" role="dialog" aria-labelledby="assessmentDitolakModalLabel{{ $apk->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="assessmentDitolakModalLabel{{ $apk->id }}">Catatan Perbaikan dari Admin</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        // Ambil revisi terbaru langsung dari query builder
                                                        $latestRevision = $apk->riwayatRevisiAssessments()
                                                            ->orderByDesc('tanggal_pengajuan')
                                                            ->first();
                                                    @endphp

                                                    @if($latestRevision)
                                                        <div class="mb-2">
                                                            <span>{{ $latestRevision->catatan ?? 'Tidak ada catatan.' }}</span>
                                                        </div>
                                                    @else
                                                        <div class="mb-2">
                                                            <strong>Undangan:</strong>
                                                            <span>Tidak ada data revisi.</span>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('assessment.revisi', $apk->id) }}" method="GET" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Ajukan Revisi</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            @endif
                        </td>

                        <td class="text-center">
                            @php
                                $routeName = Auth::user()->role === 'admin' ? 'admin.show-apk' : 'opd.show-apk';
                            @endphp
                            <a href="{{ route($routeName, $apk->id) }}" title="Detail" class="btn btn-primary btn-sm">
                                <i class="bx bxs-show" style="color: white"></i>
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
                                    // Urutkan semua data berdasarkan tanggal_pengajuan terbaru
                                    $sorted = $riwayat->sortByDesc('permohonan');

                                    // Ambil data terbaru (pertama)
                                    $latest = $sorted->first();

                                    // Ambil sisanya, kecuali yang pertama
                                    $others = $sorted->slice(1); // slice mulai dari index ke-1
                                @endphp
                                    {{-- Tabel Detail Riwayat Terbaru --}}
                                    <table style="width: 100%; margin-bottom: 1rem; border-collapse: collapse;">
                                        <tbody>
                                            <tr><th style="text-align: left;">Tanggal Pengajuan</th><td>{{ $latest->permohonan ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Status</th><td>{{ $latest->rekapAplikasi->status_label ?? '-' }}</td></tr>
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
                                            <tr><th style="text-align: left;">Perihal Permohonan</th><td>{{ $latest->jenis_permohonan ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Link Dokumentasi</th><td>
                                                    @if($latest->link_dokumentasi)
                                                        <a href="{{ $latest->link_dokumentasi }}" target="_blank">{{ $latest->link_dokumentasi }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td></tr>
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
                                                            <i class='bx bxs-file-pdf' style="font-size: 1.5rem; color: red;"></i>
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr><th style="text-align: left;">Catatan Perbaikan dari Admin</th><td>{{ $latest->catatan ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>

                                    {{-- Tabel Riwayat Lama --}}
                                    <strong>Assessment Lama:</strong>
                                    @if(count($others) > 0)
                                        <table style="width: 100%; margin-bottom: 1rem; border-collapse: collapse; background: #fff;">
                                            <thead style="background: #e5e7eb;">
                                                <tr>
                                                    <th style="text-align:left; width:20%;">Tanggal Pengajuan</th>
                                                    <th style="text-align:left; width:5%;">Surat Permohonan</th>
                                                    <th style="text-align:left; width:75%;">Catatan Perbaikan dari Admin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($others as $rev)
                                                    <tr>
                                                        <td>{{ $rev->permohonan ?? '-' }}</td>
                                                        <td>
                                                            @if($rev->surat_permohonan)
                                                                <a href="{{ asset('storage/' . $rev->surat_permohonan) }}" target="_blank" title="Lihat PDF">
                                                                    <i class='bx bxs-file-pdf' style="font-size: 1.5rem; color: red;"></i>
                                                                </a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>{{ $rev->catatan ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    {{-- Tombol Revisi --}}
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
