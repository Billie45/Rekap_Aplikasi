@extends('layouts.app')
@section('content')
    @include('components.template-tabel')

    @php
        $n = $aplikasis->firstItem();
        $headers = ['No', 'Organisasi Pemerintah Daerah', 'Nama Aplikasi', 'Nama Subdomain', 'Status Assessment', 'Detail'];
        $rows = [];

        foreach ($aplikasis as $apk) {
            if (!in_array($apk->status, ['perbaikan', 'assessment1', 'assessment2'])) continue;

            $rows[] = [
                $n++,
                $apk->opd->nama_opd ?? '-',
                $apk->nama ?? '-',
                $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank">' . $apk->subdomain . '</a>' : '-',
                in_array($apk->status, ['assessment1', 'assessment2']) ? 'assessment' : ($apk->status == 'perbaikan' ? 'perbaikan' : '-'),
                '<a href="' . route('pages.details.show-assessment', $apk->id) . '">Detail</a>',
            ];
        }
    @endphp

<x-template-tabel-3 :headers="$headers" :rows="$rows" />

    <div class="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
@endsection
