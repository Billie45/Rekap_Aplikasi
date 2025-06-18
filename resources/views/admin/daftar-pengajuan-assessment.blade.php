{{-- filepath: d:\File\xampp\htdocs\Rekap_aplikasi\resources\views\admin\daftar-pengajuan-assessment.blade.php --}}
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
                    <th>Expand</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Organisasi Pemerintah Daerah</th>
                    <th>Nama Aplikasi</th>
                    <th>Status Assessment</th>
                    <th>Jenis Pengajuan</th>
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
                        <td>
                            <div class="action-buttons">
                                @if($apk->status === 'diproses')
                                @elseif(Auth::user()->role == 'admin')
                                    @if((is_null($apk->jenis_jawaban) && $apk->status === 'assessment1' ) || ($apk->jenis_jawaban == 'Diproses' && $apk->status === 'assessment2'))
                                        <button class="btn btn-primary btn-sm terima-button" data-id="{{ $apk->id }}" data-toggle="modal" data-target="#terimaModal" title="Terima Aplikasi">
                                            <i class='bx bx-check'></i>
                                            <span class="btn-text">Terima</span>
                                        </button>
                                        <button class="btn btn-danger btn-sm revisi-button" data-id="{{ $apk->id }}" data-toggle="modal" data-target="#revisiModal" title="Tolak Aplikasi">
                                            <i class='bx bx-x'></i>
                                            <span class="btn-text">Tolak</span>
                                        </button>
                                        <button class="btn btn-warning btn-sm" title="Notifikasi">
                                            <i class='bx bx-bell'></i>
                                        </button>

                                    @elseif($apk->jenis_jawaban == 'Diterima' && ($apk->status == 'assessment1' || $apk->status == 'assessment2' || $apk->status === 'development'))
                                        <a href="{{ route('penilaian.create') }}?rekap_aplikasi_id={{ $apk->id }}" class="btn btn-sm" style="background-color: yellow; color: black;" title="Buat Penilaian">
                                            <i class='bx bx-plus-circle'></i>
                                            <span class="btn-text">Buat Penilaian</span>
                                        </a>
                                        <button class="btn btn-warning btn-sm" title="Notifikasi">
                                            <i class='bx bx-bell'></i>
                                        </button>

                                    @elseif($apk->jenis_jawaban == 'Ditolak' && ($apk->status == 'assessment1' || $apk->status == 'assessment2' || $apk->status === 'perbaikan'))
                                        <span class="btn btn-danger btn-sm" title="Assessment Ditunda">
                                            <i class='bx bx-pause-circle'></i>
                                            <span class="btn-text">Assessment ditunda</span>
                                        </span>
                                        <button class="btn btn-secondary btn-sm" title="Notifikasi">
                                            <i class='bx bx-bell'></i>
                                        </button>

                                    @elseif($apk->status == 'prosesBA'|| $apk->status == 'batal' || $apk->status == 'selesai' || ($apk->status == 'assessment2' && $apk->jenis_jawaban == null))
                                        @if($apk->latestPenilaian)
                                        <a href="{{ route('penilaian.show', $apk->latestPenilaian->id) }}" class="btn btn-sm" style="background-color: #28a745; color: white;" title="Lihat Penilaian">
                                            <i class='bx bx-show'></i>
                                            <span class="btn-text">Lihat Penilaian</span>
                                        </a>
                                            @if(($apk->status == 'prosesBA' && $apk->jenis_jawaban == 'Diterima') || ($apk->status == 'prosesBA' && $apk->jenis_jawaban == 'Diproses'))
                                                <button class="btn btn-warning btn-sm" title="Notifikasi">
                                                    <i class='bx bx-bell'></i>
                                                </button>
                                            @elseif(($apk->status == 'batal') || ($apk->status == 'selesai') || ($apk->status == 'assessment2' && $apk->jenis_jawaban == null) || ($apk->status == 'prosesBA' && $apk->jenis_jawaban == null || $apk->jenis_jawaban == 'Ditolak'))
                                                <button class="btn btn-secondary btn-sm" title="Notifikasi">
                                                    <i class='bx bx-bell'></i>
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.show-apk', $apk->id) }}" title="Detail" class="btn btn-primary btn-sm">
                                <i class="bx bx-show" style="color: white"></i>
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
                                    $sorted = $riwayat->sortByDesc('permohonan');
                                    $latest = $sorted->first();
                                    $others = $sorted->slice(1);
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
                                            <tr><th style="text-align: left;">Tipe</th><td>{{ $latest->tipe_label ?? '-' }}</td></tr>
                                            <tr><th style="text-align: left;">Jenis Permohonan</th><td>{{ $latest->jenis_permohonan ?? '-' }}</td></tr>
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
                                            <tr><th style="text-align: left;">CP OPD</th><td>{{ $latest->cp_opd_nama ?? '-' }} ({{ $latest->cp_opd_no_telepon ?? '-'}})</td></tr>
                                            <tr><th style="text-align: left;">CP Pengembang</th><td>{{ $latest->cp_pengembang_nama ?? '-' }} ({{ $latest->cp_pengembang_no_telepon ?? '-'}})</td></tr>
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
                                    {{-- <strong>Assessment Lama:</strong>
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
                                    @endif --}}
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

    <!-- Modal -->
    <div class="modal fade" id="revisiModal" tabindex="-1" role="dialog" aria-labelledby="revisiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="revisiModalLabel">Catatan Revisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="revisiForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="rekap_aplikasi_id" id="rekap_aplikasi_id">
                        <div class="form-group">
                            <label for="catatan">Catatan:</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Submit Revisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Terima -->
    <div class="modal fade" id="terimaModal" tabindex="-1" role="dialog" aria-labelledby="terimaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="terimaModalLabel">Selamat!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Assessment diterima, anda akan dialihkan menuju halaman pembuatan undangan assessment</p>
                </div>
                <div class="modal-footer">
                    <a href="#" id="buatUndanganLink" class="btn btn-primary">Buat Undangan</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('.terima-button').click(function() {
                var apkId = $(this).data('id');
                $('#buatUndanganLink').attr('href', '/undangan/create?apk_id=' + apkId);
            });

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
