@php
    $opds = $opds ?? \App\Models\Opd::all();
    $apps = isset($opd_id) ? \App\Models\MasterRekapAplikasi::where('opd_id', $opd_id)->get() : [];
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
            <!-- Assessment -->
            <div class="contentBx active">
                <div class="label">Informasi Assessment</div>
                <div class="content">
                    <label>Tanggal Permohonan:</label>
                    <div>
                        <input id="permohonan" type="date" class="form-control" name="permohonan"
                            value="{{ old('permohonan', isset($apk) && $apk->permohonan ? $apk->permohonan : \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        @error('permohonan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <label>Status Assessment:</label>
                    <select name="status">
                        {{-- <option value="diproses" {{ (old('status', $apk->status ?? '')) == 'diproses' ? 'selected' : '' }}>0. diproses</option> --}}
                        <option value="perbaikan" {{ (old('status', $apk->status ?? '')) == 'perbaikan' ? 'selected' : '' }}>1. perbaikan</option>
                        <option value="assessment1" {{ (old('status', $apk->status ?? '')) == 'assessment1' ? 'selected' : '' }}>2. assessment 1</option>
                        <option value="assessment2" {{ (old('status', $apk->status ?? '')) == 'assessment2' ? 'selected' : '' }}>3. assessment 2</option>
                        <option value="development" {{ (old('status', $apk->status ?? '')) == 'development' ? 'selected' : '' }}>4. development</option>
                        <option value="prosesBA" {{ (old('status', $apk->status ?? '')) == 'prosesBA' ? 'selected' : '' }}>5. proses BA</option>
                        <option value="selesai" {{ (old('status', $apk->status ?? '')) == 'selesai' ? 'selected' : '' }}>6. selesai</option>
                        <option value="batal" {{ (old('status', $apk->status ?? '')) == 'batal' ? 'selected' : '' }}>7. batal</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Jenis Pengembangan:</label>
                    <select name="jenis" id="jenis">
                        <option value="baru" {{ (old('jenis', $apk->jenis ?? '')) == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="pengembangan" {{ (old('jenis', $apk->jenis ?? '')) == 'pengembangan' ? 'selected' : '' }}>Pengembangan</option>
                    </select>
                    @error('jenis')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Organisasi Pemerintah Daerah:</label>
                    <select name="opd_id" id="opd_id" class="select2" style="width:100%">
                        @foreach($opds as $opd)
                            <option value="{{ $opd->id }}" {{ (old('opd_id', $apk->opd_id ?? '')) == $opd->id ? 'selected' : '' }}>
                                {{ $opd->nama_opd }}
                            </option>
                        @endforeach
                    </select>
                    @error('opd_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Nama Aplikasi:</label>
                    <div>
                        <!-- Input text untuk aplikasi baru -->
                        <input type="text" id="nama_text" name="nama_text" value="{{ old('nama', $apk->nama ?? '') }}" style="{{ (old('jenis', $apk->jenis ?? 'baru')) == 'baru' ? '' : 'display: none;' }}">

                        <!-- Dropdown untuk aplikasi pengembangan -->
                        <select id="nama_select" style="{{ (old('jenis', $apk->jenis ?? 'baru')) == 'pengembangan' ? '' : 'display: none;' }}">
                            <option value="">-- Pilih aplikasi --</option>
                            <!-- Options will be loaded dynamically -->
                        </select>

                        <!-- Hidden input untuk menyimpan nilai final -->
                        <input type="hidden" name="nama" id="nama_final" value="{{ old('nama', $apk->nama ?? '') }}">

                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <label>Nama Subdomain:</label>
                    <input type="text" name="subdomain" id="subdomain" value="{{ old('subdomain', $apk->subdomain ?? '') }}">
                    @error('subdomain')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Jenis Pengajuan Aplikasi:</label>
                    <select name="tipe" id="tipe">
                        <option value="web" {{ (old('tipe', $apk->tipe ?? '')) == 'web' ? 'selected' : '' }}>Website</option>
                        <option value="apk" {{ (old('tipe', $apk->tipe ?? '')) == 'apk' ? 'selected' : '' }}>Aplikasi Web</option>
                    </select>
                    @error('tipe')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Perihal Permohonan:</label>
                    <input type="text" name="jenis_permohonan" id="jenis_permohonan" value="{{ old('jenis_permohonan', $apk->jenis_permohonan ?? '') }}">
                    @error('jenis_permohonan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Dokumentasi Teknis:</label>
                    <input type="text" name="link_dokumentasi" id="link_dokumentasi" value="{{ old('link_dokumentasi', $apk->link_dokumentasi ?? '') }}">
                    @error('link_dokumentasi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Akun -->
            <div class="contentBx active">
                <div class="label">Informasi Akun Untuk Diskominfo</div>
                <div class="content">
                    <label>Link Login:</label>
                    <input type="text" name="akun_link" id="akun_link" value="{{ old('akun_link', $apk->akun_link ?? '') }}">
                    @error('akun_link')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Username:</label>
                    <input type="text" name="akun_username" id="akun_username" value="{{ old('akun_username', $apk->akun_username ?? '') }}">
                    @error('akun_username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Password:</label>
                    <input type="password" name="akun_password" id="akun_password" value="{{ old('akun_password', $apk->akun_password ?? '') }}">
                    @error('akun_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- CP OPD -->
            <div class="contentBx active">
                <div class="label">Contact Person OPD</div>
                <div class="content">
                    <label>Nama:</label>
                    <input type="text" name="cp_opd_nama" value="{{ old('cp_opd_nama', $apk->cp_opd_nama ?? '') }}">
                    @error('cp_opd_nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>No Telepon:</label>
                    <input type="text" name="cp_opd_no_telepon" value="{{ old('cp_opd_no_telepon', $apk->cp_opd_no_telepon ?? '') }}">
                    @error('cp_opd_no_telepon')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- CP Pengembang -->
            <div class="contentBx active">
                <div class="label">Contact Person Pengembang</div>
                <div class="content">
                    <label>Nama:</label>
                    <input type="text" name="cp_pengembang_nama" value="{{ old('cp_pengembang_nama', $apk->cp_pengembang_nama ?? '') }}">
                    @error('cp_pengembang_nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>No Telepon:</label>
                    <input type="text" name="cp_pengembang_no_telepon" value="{{ old('cp_pengembang_no_telepon', $apk->cp_pengembang_no_telepon ?? '') }}">
                    @error('cp_pengembang_no_telepon')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
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
                <div class="label">Informasi Pengembangan Aplikasi</div>
                <div class="content">
                    <label>Tanggal Assessment Terakhir:</label>
                    <input type="date" name="assesment_terakhir"
                        value="{{ isset($apk) ? ($apk->updated_at ? $apk->updated_at->format('Y-m-d') : now()->format('Y-m-d')) : now()->format('Y-m-d') }}"
                        readonly
                        class="form-control bg-light">

                    {{-- <label>Tanggal Permohonan:</label>
                    <input type="date" name="permohonan" value="{{ old('permohonan', $apk->permohonan ?? '') }}">
                    @error('permohonan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror --}}

                    {{-- <label>Tanggal Undangan Terakhir:</label>
                    <input type="date" name="undangan_terakhir" value="{{ old('undangan_terakhir', $apk->undangan_terakhir ?? '') }}">
                    @error('undangan_terakhir')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror --}}

                    <label>Tanggal Laporan Perbaikan:</label>
                    <input type="date" name="laporan_perbaikan" value="{{ old('laporan_perbaikan', $apk->laporan_perbaikan ?? '') }}">
                    @error('laporan_perbaikan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Tanggal Masuk / BA:</label>
                    <input type="date" name="tanggal_masuk_ba" value="{{ old('tanggal_masuk_ba', $apk->tanggal_masuk_ba ?? '') }}">
                    @error('tanggal_masuk_ba')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Keterangan:</label>
                    <textarea name="keterangan">{{ old('keterangan', $apk->keterangan ?? '') }}</textarea>

                    <label>Deskripsi Singkat Last Update:</label>
                    <textarea name="last_update">{{ old('last_update', $apk->last_update ?? '') }}</textarea>
                </div>
            </div>

            <!-- Server -->
            <div class="contentBx active">
                <div class="label">Detail Akses Server</div>
                <div class="content">
                    <label>Server Hosting:</label>
                    <input type="text" name="server" value="{{ old('server', $apk->server ?? '') }}">
                    @error('server')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Status Server:</label>
                    <select name="status_server">
                        <option value="CLOSE" {{ (old('status_server', $apk->status_server ?? '')) == 'CLOSE' ? 'selected' : '' }}>CLOSE</option>
                        <option value="OPEN" {{ (old('status_server', $apk->status_server ?? '')) == 'OPEN' ? 'selected' : '' }}>OPEN</option>
                    </select>
                    @error('status_server')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Tanggal Open Akses:</label>
                    <input type="date" name="open_akses" value="{{ old('open_akses', $apk->open_akses ?? '') }}">
                    @error('open_akses')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Tanggal Close Akses:</label>
                    <input type="date" name="close_akses" value="{{ old('close_akses', $apk->close_akses ?? '') }}">
                    @error('close_akses')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Urgensi:</label>
                    <input type="text" name="urgensi" value="{{ old('urgensi', $apk->urgensi ?? '') }}">
                    @error('urgensi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
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
    // Data aplikasi dari database
    const rekapApps = @json($apps ?? []);

    document.addEventListener('DOMContentLoaded', function () {
        // Get references to the elements
        const jenisSelect = document.getElementById('jenis');
        const opdSelect = document.getElementById('opd_id');
        const namaText = document.getElementById('nama_text');
        const namaSelect = document.getElementById('nama_select');
        const namaFinal = document.getElementById('nama_final');

        const tipeSelect = document.getElementById('tipe');
        const jenisPermohonanSelect = document.getElementById('jenis_permohonan');
        const subdomainInput = document.getElementById('subdomain');
        const akunLinkInput = document.getElementById('akun_link');
        const akunUsernameInput = document.getElementById('akun_username');
        const akunPasswordInput = document.getElementById('akun_password');
        const cpOpdNamaInput = document.querySelector('input[name="cp_opd_nama"]');
        const cpOpdNoTeleponInput = document.querySelector('input[name="cp_opd_no_telepon"]');
        const cpPengembangNamaInput = document.querySelector('input[name="cp_pengembang_nama"]');
        const cpPengembangNoTeleponInput = document.querySelector('input[name="cp_pengembang_no_telepon"]');

        // Function untuk memuat daftar aplikasi berdasarkan OPD terpilih
        function loadApps(opd_id) {
            // Clear existing options
            namaSelect.innerHTML = '<option value="">-- Pilih aplikasi --</option>';

            // Fetch data from server
            fetch(`/admin/get-master-apps/${opd_id}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        data.forEach(app => {
                            const option = document.createElement('option');
                            option.value = app.nama;
                            option.textContent = app.nama;
                            option.dataset.id = app.id;
                            namaSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error loading apps:', error));
        }

        // Function untuk mengisi data otomatis berdasarkan aplikasi terpilih
        function fillAppData(nama, opd_id) {
            // Reset nilai input
            tipeSelect.value = '';
            jenisPermohonanSelect.value = '';
            subdomainInput.value = '';
            akunLinkInput.value = '';
            akunUsernameInput.value = '';
            akunPasswordInput.value = '';
            cpOpdNamaInput.value = '';
            cpOpdNoTeleponInput.value = '';
            cpPengembangNamaInput.value = '';
            cpPengembangNoTeleponInput.value = '';

            // Fetch data from server
            fetch(`/admin/get-master-app-details?nama=${encodeURIComponent(nama)}&opd_id=${opd_id}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        // Auto-fill form fields dari data master
                        tipeSelect.value = data.tipe || '';
                        jenisPermohonanSelect.value = data.jenis_permohonan || '';
                        subdomainInput.value = data.subdomain || '';
                        akunLinkInput.value = data.akun_link || '';
                        akunUsernameInput.value = data.akun_username || '';
                        akunPasswordInput.value = data.akun_password || '';
                        cpOpdNamaInput.value = data.cp_opd_nama || '';
                        cpOpdNoTeleponInput.value = data.cp_opd_no_telepon || '';
                        cpPengembangNamaInput.value = data.cp_pengembang_nama || '';
                        cpPengembangNoTeleponInput.value = data.cp_pengembang_no_telepon || '';
                    } else {
                        // reset jika tidak ditemukan
                        tipeSelect.value = '';
                        jenisPermohonanSelect.value = '';
                        subdomainInput.value = '';
                        akunLinkInput.value = '';
                        akunUsernameInput.value = '';
                        akunPasswordInput.value = '';
                        cpOpdNamaInput.value = '';
                        cpOpdNoTeleponInput.value = '';
                        cpPengembangNamaInput.value = '';
                        cpPengembangNoTeleponInput.value = '';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Function untuk toggle input berdasarkan jenis yang dipilih
        function toggleNamaInput() {
            const jenis = jenisSelect.value;
            const opdId = opdSelect.value;

            if (jenis === 'pengembangan') {
                namaText.style.display = 'none';
                namaSelect.style.display = 'block';

                // Load apps for the selected OPD
                loadApps(opdId);

                // Update hidden input with selected value
                namaFinal.value = namaSelect.value;

                // Fill form fields if an app is selected
                if (namaSelect.value) {
                    fillAppData(namaSelect.value, opdId);
                }
            } else {
                namaText.style.display = 'block';
                namaSelect.style.display = 'none';

                // Update hidden input with text input value
                namaFinal.value = namaText.value;

                // Reset form fields
                tipeSelect.value = '';
                jenisPermohonanSelect.value = '';
                subdomainInput.value = '';
                akunLinkInput.value = '';
                akunUsernameInput.value = '';
                akunPasswordInput.value = '';
                cpOpdNamaInput.value = '';
                cpOpdNoTeleponInput.value = '';
                cpPengembangNamaInput.value = '';
                cpPengembangNoTeleponInput.value = '';

                if (namaText.value.trim()) {
                    fillAppData(namaText.value.trim(), opdId);
                }
            }
        }

        // Event listener when jenis changes
        jenisSelect.addEventListener('change', toggleNamaInput);

        // Event listener when OPD changes
        opdSelect.addEventListener('change', function() {
            if (jenisSelect.value === 'pengembangan') {
                loadApps(this.value);

                // Reset form fields saat OPD berubah
                tipeSelect.value = '';
                jenisPermohonanSelect.value = '';
                subdomainInput.value = '';
                akunLinkInput.value = '';
                akunUsernameInput.value = '';
                akunPasswordInput.value = '';
                cpOpdNamaInput.value = '';
                cpOpdNoTeleponInput.value = '';
                cpPengembangNamaInput.value = '';
                cpPengembangNoTeleponInput.value = '';

                fillAppData('', this.value);
            }
        });

        // Event listener when nama text input changes
        namaText.addEventListener('input', function() {
            namaFinal.value = this.value;
        });

        // Event listener when nama dropdown changes
        namaSelect.addEventListener('change', function() {
            namaFinal.value = this.value;

            // Reset form fields saat nama berubah
            tipeSelect.value = '';
            jenisPermohonanSelect.value = '';
            subdomainInput.value = '';
            akunLinkInput.value = '';
            akunUsernameInput.value = '';
            akunPasswordInput.value = '';
            cpOpdNamaInput.value = '';
            cpOpdNoTeleponInput.value = '';
            cpPengembangNamaInput.value = '';
            cpPengembangNoTeleponInput.value = '';

            if (this.value) {
                fillAppData(this.value, opdSelect.value);
            }
        });

        // Initialize on page load
        toggleNamaInput();

        // Accordion functionality
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
    });
</script>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: calc(2.375rem + 2px) !important;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.375rem !important;
        border: 1px solid #ced4da !important;
        background-color: #fff !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        padding-left: 0 !important;
        color: #212529;
        display: flex;
        align-items: center;
        height: 100%;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 10px !important;
        display: flex;
        align-items: center;
    }
    /* Perbaiki posisi tombol silang (clear) agar di tengah */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        position: absolute;
        right: 28px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2em;
        color: #888;
        cursor: pointer;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 20px;
        width: 20px;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#opd_id.select2').select2({
            placeholder: "-- Pilih OPD --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
