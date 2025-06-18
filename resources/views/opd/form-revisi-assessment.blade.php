@extends('layouts.app')

@section('content')
@include('components.template-form')

<style>
    /* Container keseluruhan dengan gradasi biru */
    .form-container {
        background: linear-gradient(135deg, #dbf5f0 0%, #a4e5e0 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Kartu utama form */
    .main-card {
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border: none;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    /* Header kartu utama dengan gradasi biru */
    .card-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        border: none;
        padding: 1.5rem;
        font-weight: 600;
        font-size: 1.2rem;
    }

    /* Seksi per bagian */
    .section-card {
        border: 2px solid #dceefc;
        border-radius: 15px;
        background: #f8fcff;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .section-card:hover {
        border-color: #2193b0;
        box-shadow: 0 5px 15px rgba(33,147,176,0.15);
    }

    /* Header seksi */
    .section-card .card-header {
        background: linear-gradient(135deg, #dceefc 0%, #f0f9ff 100%);
        color: #333;
        font-size: 1rem;
        padding: 1rem 1.5rem;
        border-radius: 13px 13px 0 0 !important;
    }

    /* Form input dan select */
    .form-control, .form-select {
        border: 2px solid #cce5f6;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        background-color: white;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2193b0;
        box-shadow: 0 0 0 0.2rem rgba(33,147,176,0.25);
    }

    /* Label */
    .form-label {
        font-weight: 600;
        color: #2a3f54;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #2193b0;
        width: 20px;
    }

    /* Bantuan teks */
    .field-help {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.25rem;
        font-style: italic;
    }

    /* Tombol submit */
    .btn-submit {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 1rem 3rem;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(33,147,176,0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(33,147,176,0.4);
    }

    /* Pesan error */
    .text-danger {
        font-size: 0.85rem;
        margin-top: 0.25rem;
        color: #e74c3c;
    }

    /* Field hanya baca */
    .readonly-field {
        background-color: #ecf6fb;
        cursor: not-allowed;
    }
</style>

<div class="form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card main-card">
                    <div class="card-header text-center">
                        <i class="fas fa-edit me-2"></i>
                        Formulir Revisi Assessment Aplikasi
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('assessment.revisi.submit', $apk->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Informasi Utama -->
                            <div class="section-card">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informasi Permohonan Revisi
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="permohonan" class="form-label">
                                                <i class="fas fa-calendar-alt"></i>
                                                Tanggal Perbaikan
                                            </label>
                                            <input id="permohonan" type="date" class="form-control" name="permohonan"
                                                value="{{ old('permohonan', isset($apk->permohonan) ? (is_string($apk->permohonan) ? $apk->permohonan : $apk->permohonan->format('Y-m-d')) : date('Y-m-d')) }}">
                                            <div class="field-help">Tanggal saat melakukan perbaikan aplikasi</div>
                                            @error('permohonan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="surat_permohonan" class="form-label">
                                                <i class="fas fa-file-pdf"></i>
                                                Surat Permohonan Revisi
                                            </label>
                                            <input id="surat_permohonan" type="file" class="form-control" name="surat_permohonan" accept="application/pdf">
                                            <div class="field-help">Upload surat permohonan revisi dalam format PDF</div>
                                            @error('surat_permohonan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="opd" class="form-label">
                                            <i class="fas fa-building"></i>
                                            Organisasi Pemerintah Daerah
                                        </label>
                                        <input type="hidden" name="opd_id" value="{{ Auth::user()->opd_id}}">
                                        <input id="opd" type="text" class="form-control readonly-field" value="{{ $namaOpd }}" readonly>
                                        <div class="field-help">OPD yang mengajukan revisi assessment</div>
                                        @error('opd_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis" class="form-label">
                                                <i class="fas fa-code-branch"></i>
                                                Jenis Pengembangan
                                            </label>
                                            <input id="jenis" type="text" class="form-control readonly-field" name="jenis"
                                                value="{{ old('jenis', $apk->jenis ?? '') }}" readonly>
                                            <div class="field-help">Jenis pengembangan aplikasi yang telah ditentukan</div>
                                            @error('jenis')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="nama" class="form-label">
                                                <i class="fas fa-tag"></i>
                                                Nama Aplikasi
                                            </label>
                                            <input id="nama" type="text" class="form-control readonly-field" name="nama"
                                                value="{{ old('nama', $apk->nama ?? '') }}" readonly>
                                            <div class="field-help">Nama aplikasi yang sedang direvisi</div>
                                            @error('nama')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Aplikasi -->
                            <div class="section-card">
                                <div class="card-header">
                                    <i class="fas fa-mobile-alt me-2"></i>
                                    Detail Aplikasi
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="subdomain" class="form-label">
                                                <i class="fas fa-link"></i>
                                                Nama Subdomain
                                            </label>
                                            <input id="subdomain" type="text" class="form-control" name="subdomain"
                                                value="{{ old('subdomain', $apk->subdomain) }}" placeholder="contoh: myapp">
                                            <div class="field-help">Contoh Subdomain: example.surakarta.go.id</div>
                                            @error('subdomain')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="tipe" class="form-label">
                                                <i class="fas fa-desktop"></i>
                                                Jenis Aplikasi
                                            </label>
                                            <select id="tipe" class="form-select" name="tipe" required>
                                                <option value="web" {{ old('tipe', $apk->tipe) == 'web' ? 'selected' : '' }}>Aplikasi Web</option>
                                                <option value="apk" {{ old('tipe', $apk->tipe) == 'apk' ? 'selected' : '' }}>Website</option>
                                            </select>
                                            <div class="field-help">Pilih tipe aplikasi yang akan di-assessment</div>
                                            @error('tipe')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis_permohonan" class="form-label">
                                                <i class="fas fa-clipboard-list"></i>
                                                Perihal Permohonan
                                            </label>
                                            <input type="text" id="jenis_permohonan" class="form-control" name="jenis_permohonan"
                                                value="{{ old('jenis_permohonan', $apk->jenis_permohonan ?? '') }}"
                                                placeholder="Jelaskan perihal permohonan revisi" required>
                                            <div class="field-help">Deskripsi singkat tentang maksud dan tujuan revisi</div>
                                            @error('jenis_permohonan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="link_dokumentasi" class="form-label">
                                                <i class="fas fa-book"></i>
                                                Dokumentasi Teknis
                                            </label>
                                            <input id="link_dokumentasi" type="url" class="form-control" name="link_dokumentasi"
                                                {{-- value="{{ old('link_dokumentasi', $apk->link_dokumentasi) }}" --}}
                                                value=""
                                                placeholder="https://docs.example.com">
                                            <div class="field-help">Link dokumentasi teknis aplikasi (opsional)</div>
                                            @error('link_dokumentasi')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Akun -->
                            <div class="section-card">
                                <div class="card-header">
                                    <i class="fas fa-user-lock me-2"></i>
                                    Informasi Akun untuk Diskominfo
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="akun_link" class="form-label">
                                            <i class="fas fa-sign-in-alt"></i>
                                            Link Login
                                        </label>
                                        <input id="akun_link" type="url" class="form-control" name="akun_link"
                                            value="{{ old('akun_link', $apk->akun_link) }}"
                                            placeholder="https://app.example.com/login">
                                        <div class="field-help">URL halaman login aplikasi untuk akses testing</div>
                                        @error('akun_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="akun_username" class="form-label">
                                                <i class="fas fa-user"></i>
                                                Username
                                            </label>
                                            <input id="akun_username" type="text" class="form-control" name="akun_username"
                                                value="{{ old('akun_username', $apk->akun_username) }}"
                                                placeholder="username_admin">
                                            <div class="field-help">Username untuk akses testing oleh Diskominfo</div>
                                            @error('akun_username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="akun_password" class="form-label">
                                                <i class="fas fa-key"></i>
                                                Password
                                            </label>
                                            <input id="akun_password" type="password" class="form-control" name="akun_password"
                                                value="{{ old('akun_password', $apk->akun_password) }}"
                                                placeholder="••••••••">
                                            <div class="field-help">Password untuk akses testing oleh Diskominfo</div>
                                            @error('akun_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Person OPD -->
                            <div class="section-card">
                                <div class="card-header">
                                    <i class="fas fa-address-book me-2"></i>
                                    Contact Person OPD
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cp_opd_nama" class="form-label">
                                                <i class="fas fa-user-tie"></i>
                                                Nama
                                            </label>
                                            <input id="cp_opd_nama" type="text" class="form-control" name="cp_opd_nama"
                                                value="{{ old('cp_opd_nama', $apk->cp_opd_nama) }}"
                                                placeholder="Nama lengkap PIC">
                                            <div class="field-help">Nama lengkap penanggung jawab dari OPD</div>
                                            @error('cp_opd_nama')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="cp_opd_no_telepon" class="form-label">
                                                <i class="fas fa-phone"></i>
                                                No Telepon
                                            </label>
                                            <input id="cp_opd_no_telepon" type="text" class="form-control" name="cp_opd_no_telepon"
                                                value="{{ old('cp_opd_no_telepon', $apk->cp_opd_no_telepon) }}"
                                                placeholder="08xxxxxxxxxx">
                                            <div class="field-help">Nomor telepon yang dapat dihubungi</div>
                                            @error('cp_opd_no_telepon')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Person Pengembang -->
                            <div class="section-card">
                                <div class="card-header">
                                    <i class="fas fa-code me-2"></i>
                                    Contact Person Pengembang
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cp_pengembang_nama" class="form-label">
                                                <i class="fas fa-user-cog"></i>
                                                Nama
                                            </label>
                                            <input id="cp_pengembang_nama" type="text" class="form-control" name="cp_pengembang_nama"
                                                value="{{ old('cp_pengembang_nama', $apk->cp_pengembang_nama) }}"
                                                placeholder="Nama developer/vendor">
                                            <div class="field-help">Nama lengkap developer atau perwakilan vendor</div>
                                            @error('cp_pengembang_nama')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="cp_pengembang_no_telepon" class="form-label">
                                                <i class="fas fa-mobile-alt"></i>
                                                No Telepon
                                            </label>
                                            <input id="cp_pengembang_no_telepon" type="text" class="form-control" name="cp_pengembang_no_telepon"
                                                value="{{ old('cp_pengembang_no_telepon', $apk->cp_pengembang_no_telepon) }}"
                                                placeholder="08xxxxxxxxxx">
                                            <div class="field-help">Nomor telepon developer untuk koordinasi teknis</div>
                                            @error('cp_pengembang_no_telepon')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Ajukan Revisi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
