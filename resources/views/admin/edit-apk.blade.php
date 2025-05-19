@php
    $opds = $opds ?? \App\Models\Opd::all();
@endphp

@extends('layouts.app')

@section('content')
@include('components.template-accondion')
@include('components.template-form')

<!-- CARD 1: Informasi Umum -->
<form action="{{ isset($apk->id) ? route('rekap-aplikasi.update', $apk->id) : route('rekap-aplikasi.store') }}" method="POST">
    @csrf
    @if(isset($apk->id))
        @method('PUT')
    @endif

    <!-- CARD 1: Informasi Umum -->
    <div class="card mb-4">
        <div class="card-header">Informasi Umum</div>
        <div class="accordion">
            <!-- Informasi -->
            <div class="contentBx active">
                <div class="label">Informasi Mengenai Aplikasi</div>
                <div class="content">
                    <label>Tanggal Permohonan:</label>
                    <div>
                        <input id="permohonan" type="date" class="form-control" name="permohonan"
                            value="{{ old('permohonan', isset($apk) && $apk->permohonan ? $apk->permohonan : \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        @error('permohonan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <label>Organisasi Pemerintah Daerah:</label>
                    <select name="opd_id">
                        @foreach($opds as $opd)
                            <option value="{{ $opd->id }}" {{ ($apk->opd_id ?? '') == $opd->id ? 'selected' : '' }}>
                                {{ $opd->nama_opd }}
                            </option>
                        @endforeach
                    </select>
                    @error('opd_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Nama Aplikasi:</label>
                    <input type="text" name="nama" value="{{ $apk->nama ?? '' }}">
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Nama Subdomain:</label>
                    <input type="text" name="subdomain" value="{{ $apk->subdomain ?? '' }}">

                    <label>Jenis Pengajuan Aplikasi:</label>
                    <select name="tipe">
                        <option value="web" {{ ($apk->tipe ?? '') == 'web' ? 'selected' : '' }}>Website</option>
                        <option value="apk" {{ ($apk->tipe ?? '') == 'apk' ? 'selected' : '' }}>Aplikasi Web</option>
                    </select>
                    @error('tipe')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Jenis Pengembagan:</label>
                    <select name="jenis">
                        <option value="pengembangan" {{ ($apk->jenis ?? '') == 'pengembangan' ? 'selected' : '' }}>Pengembangan</option>
                        <option value="baru" {{ ($apk->jenis ?? '') == 'baru' ? 'selected' : '' }}>Baru</option>
                    </select>
                    @error('jenis')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Status Assessment:</label>
                    <select name="status">
                        <option value="diproses" {{ ($apk->status ?? '') == 'diproses' ? 'selected' : '' }}>0. diproses</option>
                        <option value="perbaikan" {{ ($apk->status ?? '') == 'perbaikan' ? 'selected' : '' }}>1. perbaikan</option>
                        <option value="assessment1" {{ ($apk->status ?? '') == 'assessment1' ? 'selected' : '' }}>2. assessment 1</option>
                        <option value="assessment2" {{ ($apk->status ?? '') == 'assessment2' ? 'selected' : '' }}>3. assessment 2</option>
                        <option value="development" {{ ($apk->status ?? '') == 'development' ? 'selected' : '' }}>4. development</option>
                        <option value="prosesBA" {{ ($apk->status ?? '') == 'prosesBA' ? 'selected' : '' }}>5. proses BA</option>
                        <option value="selesai" {{ ($apk->status ?? '') == 'selesai' ? 'selected' : '' }}>6. selesai</option>
                        <option value="batal" {{ ($apk->status ?? '') == 'batal' ? 'selected' : '' }}>7. batal</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Keterangan:</label>
                    <textarea name="keterangan">{{ $apk->keterangan ?? '' }}</textarea>

                    <label>Deskripsi Singkat Last Update:</label>
                    <textarea name="last_update">{{ $apk->last_update ?? '' }}</textarea>

                    <label>Jenis Permohonan:</label>
                    <select name="jenis_permohonan">
                        <option value="subdomain" {{ ($apk->jenis_permohonan ?? '') == 'subdomain' ? 'selected' : '' }}>Subdomain</option>
                        <option value="permohonan" {{ ($apk->jenis_permohonan ?? '') == 'permohonan' ? 'selected' : '' }}>Pengembangan</option>
                    </select>

                    <label>Tanggal Masuk / BA:</label>
                    <input type="date" name="tanggal_masuk_ba" value="{{ $apk->tanggal_masuk_ba ?? '' }}">

                    <label>Dokumentasi Teknis:</label>
                    <input type="text" name="link_dokumentasi" value="{{ $apk->link_dokumentasi ?? '' }}">
                </div>
            </div>

            <!-- Akun -->
            <div class="contentBx active">
                <div class="label">Informasi Akun Untuk Diskominfo</div>
                <div class="content">
                    <label>Link Login:</label>
                    <input type="text" name="akun_link" value="{{ $apk->akun_link ?? '' }}">

                    <label>Username:</label>
                    <input type="text" name="akun_username" value="{{ $apk->akun_username ?? '' }}">

                    <label>Password:</label>
                    <input type="password" name="akun_password" value="{{ $apk->akun_password ?? '' }}">
                </div>
            </div>

            <!-- CP OPD -->
            <div class="contentBx active">
                <div class="label">Contact Person OPD</div>
                <div class="content">
                    <label>Nama:</label>
                    <input type="text" name="cp_opd_nama" value="{{ $apk->cp_opd_nama ?? '' }}">

                    <label>No Telepon:</label>
                    <input type="text" name="cp_opd_no_telepon" value="{{ $apk->cp_opd_no_telepon ?? '' }}">
                </div>
            </div>

            <!-- CP Pengembang -->
            <div class="contentBx active">
                <div class="label">Contact Person Pengembang</div>
                <div class="content">
                    <label>Nama:</label>
                    <input type="text" name="cp_pengembang_nama" value="{{ $apk->cp_pengembang_nama ?? '' }}">

                    <label>No Telepon:</label>
                    <input type="text" name="cp_pengembang_no_telepon" value="{{ $apk->cp_pengembang_no_telepon ?? '' }}">
                </div>
            </div>
        </div>
    </div>

    <!-- CARD 2: Rekap Laporan Progres -->
    <div class="card">
        <div class="card-header">Rekap Laporan Progres</div>
        <div class="accordion">
            <!-- Rekap Aplikasi -->
            <div class="contentBx active">
                <div class="label">Informasi Tambahan Rekap Aplikasi</div>
                <div class="content">
                    <label>Tanggal Assessment Terakhir:</label>
                    <input type="date" name="assesment_terakhir"
                        value="{{ isset($apk) ? ($apk->updated_at ? $apk->updated_at->format('Y-m-d') : now()->format('Y-m-d')) : now()->format('Y-m-d') }}"
                        readonly
                        class="form-control bg-light">
                </div>
            </div>

            <!-- Assessment -->
            <div class="contentBx active">
                <div class="label">Informasi Tambahan Assessment</div>
                <div class="content">
                    <label>Tanggal Undangan Terakhir:</label>
                    <input type="date" name="undangan_terakhir" value="{{ $apk->undangan_terakhir ?? '' }}">

                    <label>Tanggal Laporan Perbaikan:</label>
                    <input type="date" name="laporan_perbaikan" value="{{ $apk->laporan_perbaikan ?? '' }}">
                </div>
            </div>

            <!-- Server -->
            <div class="contentBx active">
                <div class="label">Detail Akses Server</div>
                <div class="content">
                    <label>Server Hosting:</label>
                    <input type="text" name="server" value="{{ $apk->server ?? '' }}">

                    <label>Status Server:</label>
                    <select name="status_server">
                        <option value="CLOSE" {{ ($apk->status_server ?? '') == 'CLOSE' ? 'selected' : '' }}>CLOSE</option>
                        <option value="OPEN" {{ ($apk->status_server ?? '') == 'OPEN' ? 'selected' : '' }}>OPEN</option>
                    </select>

                    <label>Tanggal Open Akses:</label>
                    <input type="date" name="open_akses" value="{{ $apk->open_akses ?? '' }}">

                    <label>Tanggal Close Akses:</label>
                    <input type="date" name="close_akses" value="{{ $apk->close_akses ?? '' }}">

                    <label>Urgensi:</label>
                    <input type="text" name="urgensi" value="{{ $apk->urgensi ?? '' }}">
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($apk->id) ? 'Update Data' : 'Simpan Data' }}
        </button>
        <a href="{{ isset($apk->id) ? route('admin.show-apk', $apk->id) : route('admin.list-apk') }}" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<script>
    const labels = document.querySelectorAll('.accordion .label');
    labels.forEach(label => {
        label.addEventListener('click', function () {
            const contentBx = this.parentElement;
            const content = contentBx.querySelector('.content');
            const isActive = contentBx.classList.contains('active');

            if (!isActive) {
                contentBx.classList.add('active');
                content.style.height = content.scrollHeight + 'px';
            } else {
                contentBx.classList.remove('active');
                content.style.height = 0;
            }
        });
    });

    // Auto-expand active content boxes
    document.querySelectorAll('.accordion .contentBx.active .content').forEach(content => {
        content.style.height = content.scrollHeight + 'px';
    });
</script>
@endsection
