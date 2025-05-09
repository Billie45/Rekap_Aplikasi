@extends('layouts.app')

@section('content')

@include('components.template-accondion')
@include('components.template-form')

    <!-- CARD 1: Informasi Umum -->
        <form action="{{ route('rekap-aplikasi.update', $apk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- CARD 1: Informasi Umum -->
            <div class="card mb-4">
                <div class="card-header">Informasi Umum</div>
                <div class="accordion">
                    <!-- Informasi -->
                    <div class="contentBx active">
                        <div class="label">Aplikasi</div>
                        <div class="content">

                            <label>Nama:</label>
                            <input type="text" name="nama" value="{{ $apk->nama }}">

                            <label>OPD:</label>
                            <select name="opd_id">
                                @foreach($opds as $opd)
                                    <option value="{{ $opd->id }}" {{ $apk->opd_id == $opd->id ? 'selected' : '' }}>
                                        {{ $opd->nama_opd }}
                                    </option>
                                @endforeach
                            </select>

                            <label>Subdomain:</label>
                            <input type="text" name="subdomain" value="{{ $apk->subdomain }}">

                            <label>Tipe:</label>
                            <select name="tipe">
                                <option value="web" {{ $apk->tipe == 'web' ? 'selected' : '' }}>Website</option>
                                <option value="apk" {{ $apk->tipe == 'apk' ? 'selected' : '' }}>Aplikasi Web</option>
                            </select>

                            <label>Jenis:</label>
                            <select name="jenis">
                                <option value="pengembangan" {{ $apk->jenis == 'pengembangan' ? 'selected' : '' }}>Pengembangan</option>
                                <option value="baru" {{ $apk->jenis == 'baru' ? 'selected' : '' }}>Baru</option>
                            </select>

                            <label>Status:</label>
                            <select name="status">
                                <option value="diproses" {{ $apk->status == 'diproses' ? 'selected' : '' }}>0. diproses</option>
                                <option value="perbaikan" {{ $apk->status == 'perbaikan' ? 'selected' : '' }}>1. perbaikan</option>
                                <option value="assessment1" {{ $apk->status == 'assessment1' ? 'selected' : '' }}>2. assessment 1</option>
                                <option value="assessment2" {{ $apk->status == 'assessment2' ? 'selected' : '' }}>3. assessment 2</option>
                                <option value="development" {{ $apk->status == 'development' ? 'selected' : '' }}>4. development</option>
                                <option value="prosesBA" {{ $apk->status == 'prosesBA' ? 'selected' : '' }}>5. proses BA</option>
                                <option value="selesai" {{ $apk->status == 'selesai' ? 'selected' : '' }}>6. selesai</option>
                                <option value="batal" {{ $apk->status == 'batal' ? 'selected' : '' }}>7. cancel</option>
                            </select>

                            <label>Server:</label>
                            <input type="text" name="server" value="{{ $apk->server }}">

                            <label>Keterangan:</label>
                            <textarea name="keterangan">{{ $apk->keterangan }}</textarea>

                            <label>Last Update:</label>
                            <textarea name="last_update">{{ $apk->last_update }}</textarea>

                            <label>Jenis Permohonan:</label>
                            <select name="jenis_permohonan">
                                <option value="subdomain" {{ $apk->jenis_permohonan == 'subdomain' ? 'selected' : '' }}>Subdomain</option>
                                <option value="permohonan" {{ $apk->jenis_permohonan == 'permohonan' ? 'selected' : '' }}>Pengembangan</option>
                            </select>

                            <label>Tanggal Masuk / BA:</label>
                            <input type="date" name="tanggal_masuk_ba" value="{{ $apk->tanggal_masuk_ba }}">

                            <label>Link Dokumentasi:</label>
                            <input type="text" name="link_dokumentasi" value="{{ $apk->link_dokumentasi }}">
                        </div>
                    </div>

                    <!-- Akun -->
                    <div class="contentBx active">
                        <div class="label">Akun</div>
                        <div class="content">
                            <label>Link:</label>
                            <input type="text" name="akun_link" value="{{ $apk->akun_link }}">

                            <label>Username:</label>
                            <input type="text" name="akun_username" value="{{ $apk->akun_username }}">

                            <label>Password:</label>
                            <input type="password" name="akun_password" value="{{ $apk->akun_password }}">
                        </div>
                    </div>

                    <!-- CP OPD -->
                    <div class="contentBx active">
                        <div class="label">CP OPD</div>
                        <div class="content">
                            <label>Nama:</label>
                            <input type="text" name="cp_opd_nama" value="{{ $apk->cp_opd_nama }}">

                            <label>No Telepon:</label>
                            <input type="text" name="cp_opd_no_telepon" value="{{ $apk->cp_opd_no_telepon }}">
                        </div>
                    </div>

                    <!-- CP Pengembang -->
                    <div class="contentBx active">
                        <div class="label">CP Pengembang</div>
                        <div class="content">
                            <label>Nama:</label>
                            <input type="text" name="cp_pengembang_nama" value="{{ $apk->cp_pengembang_nama }}">

                            <label>No Telepon:</label>
                            <input type="text" name="cp_pengembang_no_telepon" value="{{ $apk->cp_pengembang_no_telepon }}">
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
                        <div class="label">Rekap Aplikasi</div>
                        <div class="content">
                            <label>Assessment Terakhir:</label>
                            <input type="date" name="assesment_terakhir" value="{{ $apk->assesment_terakhir }}">
                        </div>
                    </div>

                    <!-- Assessment -->
                    <div class="contentBx active">
                        <div class="label">Assessment</div>
                        <div class="content">
                            <label>Permohonan:</label>
                            <input type="date" name="permohonan" value="{{ $apk->permohonan }}">

                            <label>Undangan Terakhir:</label>
                            <input type="date" name="undangan_terakhir" value="{{ $apk->undangan_terakhir }}">

                            <label>Laporan Perbaikan:</label>
                            <input type="date" name="laporan_perbaikan" value="{{ $apk->laporan_perbaikan }}">
                        </div>
                    </div>

                    <!-- Server -->
                    <div class="contentBx active">
                        <div class="label">Server</div>
                        <div class="content">
                            <label>Status Server:</label>
                            <select name="status_server">
                                <option value="CLOSE" {{ $apk->status_server == 'CLOSE' ? 'selected' : '' }}>CLOSE</option>
                                <option value="OPEN" {{ $apk->status_server == 'OPEN' ? 'selected' : '' }}>OPEN</option>
                            </select>

                            <label>Open Akses:</label>
                            <input type="date" name="open_akses" value="{{ $apk->open_akses }}">

                            <label>Close Akses:</label>
                            <input type="date" name="close_akses" value="{{ $apk->close_akses }}">

                            <label>Urgensi:</label>
                            <input type="text" name="urgensi" value="{{ $apk->urgensi }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('rekap-aplikasi.index') }}" class="btn btn-secondary">Kembali</a>
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

            // {{-- REVISI TANGGAL 08-05-2025 --}}

            document.querySelectorAll('.accordion .contentBx.active .content').forEach(content => {
                content.style.height = content.scrollHeight + 'px';
            });
        </script>
@endsection
