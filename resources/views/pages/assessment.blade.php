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
                '<div class="text-center"><a href="' . route('pages.details.show-assessment', $apk->id) . '" title="Detail"><i class="bx bxs-show" style="font-size: 1.5rem;"></i></a></div>',
            ];
        }
    @endphp

<div class="bg-white rounded shadow p-4 mt-4">
<h4 class="text-xl font-bold text-blue-500 pb-2 border-b-2 border-gray-200 mb-4">Daftar Aplikasi Tahap Assessment</h4>
<x-template-tabel-3 :headers="$headers" :rows="$rows" />

    <div class="mt-3">
        {{ $aplikasis->links('pagination::tailwind') }}
    </div>
</div>
@endsection
