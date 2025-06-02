@extends('layouts.app')

@section('content')
@include('components.template-form')
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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Formulir Pengajuan Assessment Aplikasi</div>

                <div class="card-body">
                    <form action="{{ route('pengajuan-assessment.storeAssessment') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Utama -->
                        {{-- REVISI TANGGAL 08-05-2025 --}}

                        <div class="form-group row">
                            <label for="permohonan" class="col-md-3 col-form-label text-md-right">Tanggal Permohonan</label>
                            <div class="col-md-9">
                                <input id="permohonan" type="date" class="form-control" name="permohonan"
                                    value="{{ old('permohonan', date('Y-m-d')) }}">
                                @error('permohonan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surat_permohonan" class="col-md-3 col-form-label text-md-right">Surat Permohonan</label>
                            <div class="col-md-9">
                                <input id="surat_permohonan" type="file" class="form-control" name="surat_permohonan" style="border: 1px solid #ced4da; padding: .375rem .75rem;" accept="application/pdf">
                                @error('surat_permohonan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="opd" class="col-md-3 col-form-label text-md-right">Organisasi Pemerintah Daerah</label>
                            <div class="col-md-9">
                                <input type="hidden" name="opd_id" value="{{ Auth::user()->opd_id}}">
                                <input id="opd" type="text" class="form-control" value="{{ $namaOpd}}" readonly>
                                @error('opd_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis" class="col-md-3 col-form-label text-md-right">jenis pengembangan</label>
                            <div class="col-md-9">
                                <select id="jenis" class="form-control" name="jenis" required>
                                    <option value="baru" {{ old('jenis') == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="pengembangan" {{ old('jenis') == 'pengembangan' ? 'selected' : '' }}>Pengembangan</option>
                                </select>
                                @error('jenis')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label text-md-right">Nama Aplikasi</label>
                            <div class="col-md-9">
                                {{-- Input teks untuk "baru" --}}
                                <input id="nama_text" name="nama" type="text" class="form-control" style="display: none;" value="{{ old('nama') }}">

                                {{-- Dropdown untuk "pengembangan" --}}
                                <select id="nama_select" class="form-control" style="display: none;">
                                    <option value="">-- Pilih aplikasi --</option>
                                    @foreach($apps as $app)
                                        <option value="{{ $app->nama }}" {{ old('nama') == $app->nama ? 'selected' : '' }}>
                                            {{ $app->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Input hidden final yang dikirim ke server --}}
                                <input type="hidden" name="nama" id="nama_final" value="{{ old('nama') }}">

                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subdomain" class="col-md-3 col-form-label text-md-right">Nama Subdomain</label>
                            <div class="col-md-9">
                                <input id="subdomain" type="text" class="form-control" name="subdomain"
                                    value="{{ old('subdomain') }}">
                                @error('subdomain')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipe" class="col-md-3 col-form-label text-md-right">jenis Pengajuan Aplikasi</label>
                            <div class="col-md-9">
                                <select id="tipe" class="form-control" name="tipe" required>
                                    <option value="web" {{ old('tipe') == 'web' ? 'selected' : '' }}>Aplikasi Web</option>
                                    <option value="apk" {{ old('tipe') == 'apk' ? 'selected' : '' }}>Website</option>
                                </select>
                                @error('tipe')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="last_update" class="col-md-3 col-form-label text-md-right">Deskripsi Singkat Last Update</label>
                            <div class="col-md-9">
                                <textarea id="last_update" class="form-control" name="last_update" rows="2">{{ old('last_update') }}</textarea>
                                @error('last_update')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label for="jenis_permohonan" class="col-md-3 col-form-label text-md-right">Jenis Permohonan</label>
                            <div class="col-md-9">
                                <select id="jenis_permohonan" class="form-control" name="jenis_permohonan" required>
                                    <option value="subdomain" {{ old('jenis_permohonan') == 'subdomain' ? 'selected' : '' }}>Subdomain</option>
                                    <option value="permohonan" {{ old('jenis_permohonan') == 'permohonan' ? 'selected' : '' }}>Pengembangan</option>
                                </select>
                                @error('jenis_permohonan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="jenis_permohonan" class="col-md-3 col-form-label text-md-right">Perihal Permohonan</label>
                            <div class="col-md-9">
                                <input id="jenis_permohonan" type="text" class="form-control " name="jenis_permohonan"
                                    value="{{ old('jenis_permohonan') }}">
                                @error('jenis_permohonan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- REVISI TANGGAL 08-05-2025 --}}

                        {{-- <div class="form-group row">
                            <label for="undangan_terakhir" class="col-md-3 col-form-label text-md-right">Undangan Terakhir</label>
                            <div class="col-md-9">
                                <input id="undangan_terakhir" type="date" class="form-control" name="undangan_terakhir"
                                    value="{{ old('undangan_terakhir') }}">
                                @error('undangan_terakhir')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label for="tanggal_masuk_ba" class="col-md-3 col-form-label text-md-right">Rekom Terakhir</label>
                            <div class="col-md-9">
                                <input id="tanggal_masuk_ba" type="date" class="form-control" name="tanggal_masuk_ba"
                                    value="{{ old('tanggal_masuk_ba') }}">
                                @error('tanggal_masuk_ba')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label for="laporan_perbaikan" class="col-md-3 col-form-label text-md-right">Laporan Perbaikan</label>
                            <div class="col-md-9">
                                <input id="laporan_perbaikan" type="date" class="form-control" name="laporan_perbaikan"
                                    value="{{ old('laporan_perbaikan') }}">
                                @error('laporan_perbaikan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="link_dokumentasi" class="col-md-3 col-form-label text-md-right">Dokumentasi Teknis</label>
                            <div class="col-md-9">
                                <input id="link_dokumentasi" type="url" class="form-control input-like-select" name="link_dokumentasi"
                                    value="{{ old('link_dokumentasi') }}">
                                @error('link_dokumentasi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi akun -->
                        <div class="card mb-3">
                            <div class="card-header">Informasi Akun Untuk Diskominfo</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="akun_link" class="col-md-3 col-form-label text-md-right">Link Login</label>
                                    <div class="col-md-9">
                                        <input id="akun_link" type="url" class="form-control input-like-select" name="akun_link"
                                            value="{{ old('akun_link') }}">
                                        @error('akun_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="akun_username" class="col-md-3 col-form-label text-md-right">Username</label>
                                    <div class="col-md-9">
                                        <input id="akun_username" type="text" class="form-control" name="akun_username"
                                            value="{{ old('akun_username') }}">
                                        @error('akun_username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="akun_password" class="col-md-3 col-form-label text-md-right">Password</label>
                                    <div class="col-md-9">
                                        <input id="akun_password" type="password" class="form-control" name="akun_password"
                                            value="{{ old('akun_password') }}">
                                        @error('akun_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CP OPD -->
                        <div class="card mb-3">
                            <div class="card-header">Contact Person OPD</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="cp_opd_nama" class="col-md-3 col-form-label text-md-right">Nama</label>
                                    <div class="col-md-9">
                                        <input id="cp_opd_nama" type="text" class="form-control" name="cp_opd_nama"
                                            value="{{ old('cp_opd_nama') }}">
                                        @error('cp_opd_nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cp_opd_no_telepon" class="col-md-3 col-form-label text-md-right">No Telepon</label>
                                    <div class="col-md-9">
                                        <input id="cp_opd_no_telepon" type="text" class="form-control" name="cp_opd_no_telepon"
                                            value="{{ old('cp_opd_no_telepon') }}">
                                        @error('cp_opd_no_telepon')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CP Pengembang -->
                        <div class="card mb-3">
                            <div class="card-header">Contact Person Pengembang</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="cp_pengembang_nama" class="col-md-3 col-form-label text-md-right">Nama</label>
                                    <div class="col-md-9">
                                        <input id="cp_pengembang_nama" type="text" class="form-control" name="cp_pengembang_nama"
                                            value="{{ old('cp_pengembang_nama') }}">
                                        @error('cp_pengembang_nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cp_pengembang_no_telepon" class="col-md-3 col-form-label text-md-right">No Telepon</label>
                                    <div class="col-md-9">
                                        <input id="cp_pengembang_no_telepon" type="text" class="form-control" name="cp_pengembang_no_telepon"
                                            value="{{ old('cp_pengembang_no_telepon') }}">
                                        @error('cp_pengembang_no_telepon')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fas fa-paper-plane mr-2"></i>Ajukan Assessment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const rekapApps = @json($apps);

    document.addEventListener('DOMContentLoaded', function () {
    // Get references to the elements
    const jenisSelect = document.querySelector('select[name="jenis"]');
    const inputText = document.getElementById('nama_text');
    const selectDropdown = document.getElementById('nama_select');
    const finalInput = document.getElementById('nama_final');

    const tipeInput = document.querySelector('select[name="tipe"]');
    const jenisPermohonanInput = document.querySelector('input[name="jenis_permohonan"]');
    const subdomainInput = document.querySelector('input[name="subdomain"]');
    const akunLinkInput = document.querySelector('input[name="akun_link"]');
    const akunUsernameInput = document.querySelector('input[name="akun_username"]');
    const akunPasswordInput = document.querySelector('input[name="akun_password"]');
    const cpOpdNamaInput = document.querySelector('input[name="cp_opd_nama"]');
    const cpOpdNoTeleponInput = document.querySelector('input[name="cp_opd_no_telepon"]');
    const cpPengembangNamaInput = document.querySelector('input[name="cp_pengembang_nama"]');
    const cpPengembangNoTeleponInput = document.querySelector('input[name="cp_pengembang_no_telepon"]');

    function isiFieldOtomatis(nama) {
        const found = rekapApps.find(item =>
            item.nama === nama && item.opd_id == {{ Auth::user()->opd_id }}
        );

        if (found) {
            tipeInput.value = found.tipe;
            jenisPermohonanInput.value = found.jenis_permohonan;
            subdomainInput.value = found.subdomain;
            akunLinkInput.value = found.akun_link;
            akunUsernameInput.value = found.akun_username;
            akunPasswordInput.value = found.akun_password;
            cpOpdNamaInput.value = found.cp_opd_nama;
            cpOpdNoTeleponInput.value = found.cp_opd_no_telepon;
            cpPengembangNamaInput.value = found.cp_pengembang_nama;
            cpPengembangNoTeleponInput.value = found.cp_pengembang_no_telepon;
        } else {
            // reset jika tidak ditemukan
            tipeInput.value = '';
            jenisPermohonanInput.value = '';
            subdomainInput.value = '';
            akunLinkInput.value = '';
            akunUsernameInput.value = '';
            akunPasswordInput.value = '';
            cpOpdNamaInput.value = '';
            cpOpdNoTeleponInput.value = '';
            cpPengembangNamaInput.value = '';
            cpPengembangNoTeleponInput.value = '';
        }
    }

    function toggleNamaInput() {
        const jenis = jenisSelect.value;

        if (jenis === 'pengembangan') {
            inputText.style.display = 'none';
            inputText.removeAttribute('required');

            selectDropdown.style.display = 'block';
            selectDropdown.setAttribute('required', 'required');

            // Update the hidden input with the selected option value
            finalInput.value = selectDropdown.value;
            isiFieldOtomatis(selectDropdown.value);
        } else {
            inputText.style.display = 'block';
            inputText.setAttribute('required', 'required');

            selectDropdown.style.display = 'none';
            selectDropdown.removeAttribute('required');

            // Update the hidden input with the text input value
            finalInput.value = inputText.value;

            // reset jika bukan pengembangan
            tipeInput.value = '';
            jenisPermohonanInput.value = '';
            subdomainInput.value = '';
            akunLinkInput.value = '';
            akunUsernameInput.value = '';
            akunPasswordInput.value = '';
            cpOpdNamaInput.value = '';
            cpOpdNoTeleponInput.value = '';
            cpPengembangNamaInput.value = '';
            cpPengembangNoTeleponInput.value = '';
        }
    }

        // Event listener saat jenis pengembangan berubah
        jenisSelect.addEventListener('change', toggleNamaInput);

        // Event listener saat dropdown aplikasi berubah
        selectDropdown.addEventListener('change', function () {
            finalInput.value = this.value;
            isiFieldOtomatis(this.value);
        });

        // Event listener saat input text berubah
        inputText.addEventListener('input', function () {
            finalInput.value = this.value;
        });

        // Panggil saat halaman load
        toggleNamaInput();
    });
</script>
@endsection
