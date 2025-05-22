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
                <div class="card-header">Formulir Revisi Assessment Aplikasi</div>

                <div class="card-body">
                    <form action="{{ route('assessment.revisi.submit', $apk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Utama -->
                        <div class="form-group row">
                            <label for="permohonan" class="col-md-3 col-form-label text-md-right">Tanggal Perbaikan</label>
                            <div class="col-md-9">
                                <input id="permohonan" type="date" class="form-control" name="permohonan"
                                    value="{{ old('permohonan', isset($apk->permohonan) ? (is_string($apk->permohonan) ? $apk->permohonan : $apk->permohonan->format('Y-m-d')) : date('Y-m-d')) }}" >
                                @error('permohonan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surat_permohonan" class="col-md-3 col-form-label text-md-right">Surat Permohonan</label>
                            <div class="col-md-9">
                                <input id="surat_permohonan" type="file" class="form-control" name="surat_permohonan" style="border: 1px solid #ced4da; padding: .375rem .75rem;">
                                @error('surat_permohonan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="opd" class="col-md-3 col-form-label text-md-right">Organisasi Pemerintah Daerah</label>
                            <div class="col-md-9">
                                <input type="hidden" name="opd_id" value="{{ Auth::user()->opd_id}}">
                                <input id="opd" type="text" class="form-control" value="{{ $namaOpd }}" readonly>
                                @error('opd_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis" class="col-md-3 col-form-label text-md-right">Jenis Pengembangan</label>
                            <div class="col-md-9">
                                <input id="jenis" type="text" class="form-control" name="jenis"
                                    value="{{ old('jenis', $apk->jenis ?? '') }}" readonly>
                                @error('jenis')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label text-md-right">Nama Aplikasi</label>
                            <div class="col-md-9">
                                <input id="nama" type="text" class="form-control" name="nama"
                                    value="{{ old('nama', $apk->nama ?? '') }}" readonly>
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="subdomain" class="col-md-3 col-form-label text-md-right">Nama Subdomain</label>
                            <div class="col-md-9">
                                <input id="subdomain" type="text" class="form-control" name="subdomain"
                                    value="{{ old('subdomain', $apk->subdomain) }}">
                                @error('subdomain')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipe" class="col-md-3 col-form-label text-md-right">jenis Pengajuan Aplikasi</label>
                            <div class="col-md-9">
                                <select id="tipe" class="form-control" name="tipe" required>
                                    <option value="web" {{ old('tipe', $apk->tipe) == 'web' ? 'selected' : '' }}>Aplikasi Web</option>
                                    <option value="apk" {{ old('tipe', $apk->tipe) == 'apk' ? 'selected' : '' }}>Website</option>
                                </select>
                                @error('tipe')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="last_update" class="col-md-3 col-form-label text-md-right">Deskripsi Singkat Last Update</label>
                            <div class="col-md-9">
                                <textarea id="last_update" class="form-control" name="last_update" rows="2">{{ old('last_update', $apk->last_update) }}</textarea>
                                @error('last_update')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="jenis_permohonan" class="col-md-3 col-form-label text-md-right">Jenis Pengembangan</label>
                            <div class="col-md-9">
                                <select id="jenis_permohonan" class="form-control" name="jenis_permohonan" required>
                                    <option value="subdomain" {{ old('jenis_permohonan', $apk->jenis_permohonan) == 'subdomain' ? 'selected' : '' }}>Subdomain</option>
                                    <option value="permohonan" {{ old('jenis_permohonan', $apk->jenis_permohonan) == 'permohonan' ? 'selected' : '' }}>Pengembangan</option>
                                </select>
                                @error('jenis_permohonan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link_dokumentasi" class="col-md-3 col-form-label text-md-right">Dokumentasi Teknis</label>
                            <div class="col-md-9">
                                <input id="link_dokumentasi" type="url" class="form-control input-like-select" name="link_dokumentasi"
                                    value="{{ old('link_dokumentasi', $apk->link_dokumentasi) }}">
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
                                            value="{{ old('akun_link', $apk->akun_link) }}">
                                        @error('akun_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="akun_username" class="col-md-3 col-form-label text-md-right">Username</label>
                                    <div class="col-md-9">
                                        <input id="akun_username" type="text" class="form-control" name="akun_username"
                                            value="{{ old('akun_username', $apk->akun_username) }}">
                                        @error('akun_username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="akun_password" class="col-md-3 col-form-label text-md-right">Password</label>
                                    <div class="col-md-9">
                                        <input id="akun_password" type="password" class="form-control" name="akun_password"
                                            value="{{ old('akun_password', $apk->akun_password) }}">
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
                                            value="{{ old('cp_opd_nama', $apk->cp_opd_nama) }}">
                                        @error('cp_opd_nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cp_opd_no_telepon" class="col-md-3 col-form-label text-md-right">No Telepon</label>
                                    <div class="col-md-9">
                                        <input id="cp_opd_no_telepon" type="text" class="form-control" name="cp_opd_no_telepon"
                                            value="{{ old('cp_opd_no_telepon', $apk->cp_opd_no_telepon) }}">
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
                                            value="{{ old('cp_pengembang_nama', $apk->cp_pengembang_nama) }}">
                                        @error('cp_pengembang_nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cp_pengembang_no_telepon" class="col-md-3 col-form-label text-md-right">No Telepon</label>
                                    <div class="col-md-9">
                                        <input id="cp_pengembang_no_telepon" type="text" class="form-control" name="cp_pengembang_no_telepon"
                                            value="{{ old('cp_pengembang_no_telepon', $apk->cp_pengembang_no_telepon) }}">
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
                                    <i class="fas fa-paper-plane mr-2"></i>Ajukan Revisi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
