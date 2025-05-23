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
        /* Samakan style Select2 dengan input-like-select */
        .select2-container--default .select2-selection--single {
            height: calc(2.375rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            background-color: #fff;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
            padding-left: 0 !important;
            color: #000000;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 10px !important;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .btn, .form-control, .form-select {
            border-radius: 5px !important;
        }
    </style>

    <h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Manajemen Assessment Aplikasi</h4>

    {{-- Tombol Tambah --}}
    <div class="mb-3 my-2">
        <a href="{{ route('admin.create-apk') }}" class="btn btn-light px-4 py-2 rounded-4 shadow border">
            Tambah Aplikasi
        </a>
    </div>

    {{-- Form Filter --}}
    <form method="GET" action="{{ route('rekap-aplikasi.index') }}" class="row g-3 mb-4">
        <div class="col-md-2">
            <input type="text" name="nama" class="form-control input-like-select" placeholder="Nama Aplikasi" value="{{ request('nama') }}">
        </div>

        <div class="col-md-2">
            <select name="opd_id" class="form-select input-like-select select2">
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
                {{-- <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option> --}}
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

    @php
        $n = $aplikasis->firstItem();
        $headers = ['No', 'Organisasi Pemerintah Daerah', 'Nama Aplikasi', 'Nama Subdomain', 'Status Assessment', 'Detail'];
        $rows = [];

        foreach ($aplikasis as $apk) {

            $rows[] = [
                $n++,
                $apk->opd->nama_opd ?? '-',
                $apk->nama ?? '-',
                $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-',
                $apk->status_label ?? '-',
                '<div class="text-center"><a href="' . route('admin.show-apk', $apk->id) . '" title="Detail"><i class="bx bxs-show" style="font-size: 1.5rem;"></i></a></div>',
            ];
        }
    @endphp

    <x-template-tabel-3 :headers="$headers" :rows="$rows" />

    <div class="mt-3">
        {{ $aplikasis->appends(request()->query())->links('pagination::tailwind') }}
    </div>

    <script>
        function toggleForm() {
            const form = document.getElementById('formTambah');
            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
        }
    </script>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Pilih OPD --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
@endsection
