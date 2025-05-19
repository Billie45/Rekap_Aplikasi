@extends('layouts.app')
@section('content')
    @include('components.template-tabel')

    @php
        $n = $aplikasis->firstItem();
        $headers = ['No', 'Organisasi Pemerintah Daerah', 'Nama Aplikasi', 'Nama Subdomain', 'Status Assessment', 'Detail'];
        $rows = [];

        foreach ($aplikasis as $apk) {
            if (!in_array($apk->status, ['selesai', 'batal'])) continue;

            $rows[] = [
                $n++,
                $apk->opd->nama_opd ?? '-',
                $apk->nama ?? '-',
                $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-',
                $apk->status_label ?? '-',
                '<div class="text-center"><a href="' . route('pages.details.show-selesai', $apk->id) . '" title="Detail"><i class="bx bxs-show" style="font-size: 1.5rem;"></i></a></div>',
            ];
        }
    @endphp

<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Daftar Aplikasi Tahap Selesai</h4>
<x-template-tabel-3 :headers="$headers" :rows="$rows" />

    <div class="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
