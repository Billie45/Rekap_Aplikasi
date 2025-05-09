@extends('layouts.app')
@section('content')
    <style>
        .input-like-select {
            height: calc(2.375rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            background-color: #fff;
        }
    </style>

    {{-- Tombol Tambah --}}
    <div class="mb-3 my-2">
        <button type="button" class="btn btn-light px-4 py-2 rounded-4 shadow border" data-bs-toggle="modal" data-bs-target="#tambahAplikasiModal">
            Tambah
        </button>
    </div>

    {{-- Pop Up Form Tambah --}}
    <div class="modal fade" id="tambahAplikasiModal" tabindex="-1" aria-labelledby="tambahAplikasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">

                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAplikasiModalLabel">Tambah Aplikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('rekap-aplikasi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Aplikasi</label>
                            <input type="text" class="form-control input-like-select id="nama" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label for="opd" class="form-label">OPD</label>
                            <select class="form-select input-like-select" id="opd_id" name="opd_id" required>
                                <option value="">-- Pilih OPD --</option>
                                @foreach($opds as $opd)
                                    <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subdomain" class="form-label">Subdomain</label>
                            <input type="text" class="form-control input-like-select id="subdomain" name="subdomain" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe</label>
                            <select class="form-select input-like-select" id="tipe" name="tipe" required>
                                <option value="">-- Pilih tipe --</option>
                                <option value="apk">Aplikasi Web</option>
                                <option value="web">Website</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Form Filter --}}
    <form method="GET" action="{{ route('rekap-aplikasi.index') }}" class="row g-3 mb-4">
        <div class="col-md-2">
            <input type="text" name="nama" class="form-control input-like-select" placeholder="Nama Aplikasi" value="{{ request('nama') }}">
        </div>

        <div class="col-md-2">
            <select name="opd_id" class="form-select input-like-select">
                <option value="">-- Pilih OPD --</option>
                @foreach($opds as $opd)
                    <option value="{{ $opd->id }}" {{ request('opd_id') == $opd->id ? 'selected' : '' }}>
                        {{ $opd->nama_opd }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="tipe" class="form-select input-like-select">
                <option value="">-- Pilih Tipe --</option>
                <option value="web" {{ request('tipe') == 'web' ? 'selected' : '' }}>Website</option>
                <option value="apk" {{ request('tipe') == 'apk' ? 'selected' : '' }}>Aplikasi Web</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="jenis" class="form-select input-like-select">
                <option value="">-- Pilih Jenis --</option>
                <option value="baru" {{ request('jenis') == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="pengembangan" {{ request('jenis') == 'pengembangan' ? 'selected' : '' }}>Pengembangan</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select input-like-select">
                <option value="">-- Pilih Status --</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                <option value="assessment1" {{ request('status') == 'assessment1' ? 'selected' : '' }}>Assessment 1</option>
                <option value="assessment2" {{ request('status') == 'assessment2' ? 'selected' : '' }}>Assessment 2</option>
                <option value="development" {{ request('status') == 'development' ? 'selected' : '' }}>Development</option>
                <option value="prosesBA" {{ request('status') == 'prosesBA' ? 'selected' : '' }}>Proses BA</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
            </select>
        </div>

        <div class="col-md-2">
            <input type="text" name="server" class="form-control input-like-select" placeholder="Server" value="{{ request('server') }}">
        </div>

        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('rekap-aplikasi.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Tabel Rekap Aplikasi --}}
    @include('components.template-tabel')
    <div class="table-wrapper mt-3">
        <table class="compact-table">
            <thead>
                <tr>
                    <th class="sticky-col sticky-col-1"rowspan="2">No</th>
                    <th class="sticky-col sticky-col-2"rowspan="2">Nama Aplikasi</th>
                    <th colspan="11">Informasi Umum</th>
                    <th colspan="3">Akun</th>
                    <th colspan="2">CP OPD</th>
                    <th colspan="2">CP Pengembang</th>
                    <th colspan="1">Rekap Aplikasi</th>
                    <th colspan="3">Assessment</th>
                    <th colspan="4">Server</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    {{-- Informasi Umum --}}
                    <th>OPD</th>
                    <th>Subdomain</th>
                    <th>Status</th>
                    <th>Jenis</th>
                    <th>Tipe</th>
                    <th>Server</th>
                    <th>Keterangan</th>
                    <th>Last Update</th>
                    <th>Jenis Permohonan</th>
                    <th>Tanggal Masuk / BA</th>
                    <th>Link Dokumentasi</th>

                    {{-- Akun --}}
                    <th>Link</th>
                    <th>Username</th>
                    <th>Password</th>

                    {{-- CP OPD --}}
                    <th>Nama</th>
                    <th>No Telepon</th>

                    {{-- CP Pengembang --}}
                    <th>Nama</th>
                    <th>No Telepon</th>

                    {{-- Rekap --}}
                    <th>Assessment Terakhir</th>
                    <th>Permohonan</th>
                    <th>Undangan Terakhir</th>
                    <th>Laporan Perbaikan</th>

                    {{-- Server --}}
                    <th>Status</th>
                    <th>Open Akses</th>
                    <th>Close Akses</th>
                    <th>Urgensi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $n = $aplikasis->firstItem();
                @endphp
                @foreach($aplikasis as $index => $apk)
                <tr>
                    <td class="sticky-col sticky-col-1">{{ $n++ }}</td>
                    {{-- Informasi Umum --}}
                    <td class="sticky-col sticky-col-2">{{ $apk->nama }}</td>
                    <td>{{ $apk->opd->nama_opd ?? '-' }}</td>
                    <td>
                        @if ($apk->subdomain)
                            <a href="https://{{ $apk->subdomain }}" target="_blank">{{ $apk->subdomain }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $apk->status_label ?? '-' }}</td>
                    <td>{{ $apk->jenis ?? '-' }}</td>
                    <td>{{ $apk->tipe_label ?? '-' }}</td>
                    <td>{{ $apk->server ?? '-' }}</td>
                    <td>{{ $apk->keterangan ?? '-' }}</td>
                    <td>{{ $apk->last_update ?? '-' }}</td>
                    <td>{{ $apk->jenis_permohonan ?? '-' }}</td>
                    <td>{{ $apk->tanggal_masuk_ba ?? '-' }}</td>
                    <td>
                        @if ($apk->link_dokumentasi)
                            <a href="{{ $apk->link_dokumentasi }}" target="_blank">LINK</a>
                        @else
                            -
                        @endif
                    </td>

                    {{-- Akun --}}
                    <td>
                        @if ($apk->akun_link)
                            <a href="{{ $apk->akun_link }}" target="_blank">LINK</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $apk->akun_username ?? '-' }}</td>
                    <td>{{ $apk->akun_password ?? '-' }}</td>

                    {{-- CP OPD --}}
                    <td>{{ $apk->cp_opd_nama ?? '-' }}</td>
                    <td>{{ $apk->cp_opd_no_telepon ?? '-' }}</td>

                    {{-- CP Pengembang --}}
                    <td>{{ $apk->cp_pengembang_nama ?? '-' }}</td>
                    <td>{{ $apk->cp_pengembang_no_telepon ?? '-' }}</td>

                    {{-- Rekap --}}
                    <td>{{ $apk->assesment_terakhir ?? '-' }}</td>
                    <td>{{ $apk->permohonan ?? '-' }}</td>
                    <td>{{ $apk->undangan_terakhir ?? '-' }}</td>
                    <td>{{ $apk->laporan_perbaikan ?? '-' }}</td>

                    {{-- Server --}}
                    <td>{{ $apk->status_server ?? '-' }}</td>
                    <td>{{ $apk->open_akses ?? '-' }}</td>
                    <td>{{ $apk->close_akses ?? '-' }}</td>
                    <td>{{ $apk->urgensi ?? '-' }}</td>

                    {{-- Aksi --}}
                    <td>
                        <a href="{{ route('rekap-aplikasi.edit', $apk->id) }}">Edit</a>
                        <form action="{{ route('rekap-aplikasi.destroy', $apk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus aplikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: red">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $aplikasis->appends(request()->query())->links('pagination::tailwind') }}
    </div>

    <script>
        function toggleForm() {
            const form = document.getElementById('formTambah');
            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
        }
    </script>
@endsection
