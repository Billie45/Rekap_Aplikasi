@extends('layouts.app')
@section('content')

@php
// Data utama yang paling penting - tampilan prioritas
$mainAssessmentData = [
    // ['label' => 'Tanggal Permohonan', 'value' => $apk->permohonan ?? '-'],
    ['label' => 'Organisasi Pemerintah Daerah', 'value' => $apk->opd->nama_opd ?? '-'],
    ['label' => 'Jenis Pengajuan', 'value' => $apk->jenis ?? '-'],
    // ['label' => 'Nama Aplikasi', 'value' => $apk->nama ?? '-', 'highlight' => true],
    // ['label' => 'Status Assessment', 'value' => $apk->status_label ?? '-', 'highlight' => true],
    ['label' => 'Subdomain', 'value' => $apk->subdomain ? '<a href="https://' . $apk->subdomain . '" target="_blank" class="text-blue-600 hover:underline">' . $apk->subdomain . '</a>': '-'],
    ['label' => 'Jenis Pengajuan Aplikasi', 'value' => $apk->tipe_label ?? '-'],
    ['label' => 'Perihal Permohonan', 'value' => $apk->jenis_permohonan ?? '-'],
    ['label' => 'Link Dokumentasi', 'value' => $apk->link_dokumentasi ? '<a href="' . $apk->link_dokumentasi . '" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumentasi</a>' : '-'],
];

// Data detail dalam format card yang bisa di-collapse
$detailSections = [
    'access' => [
        'title' => 'Akses & Akun',
        'icon' => 'bx-key',
        'data' => [
            ['label' => 'Login Info', 'value' =>
                $apk->akun_link && $apk->akun_username && $apk->akun_password
                    ? '<div class="space-y-1"><div><strong>Link:</strong> <a href="' . $apk->akun_link . '" target="_blank" class="text-blue-600">Login</a></div><div><strong>Username:</strong> ' . $apk->akun_username . '</div><div><strong>Password:</strong> ' . $apk->akun_password . '</div></div>'
                    : '-'
            ],


        ]
    ],
    'contact' => [
        'title' => 'Informasi Kontak',
        'icon' => 'bx-user',
        'data' => [
            ['label' => 'Contact Person OPD', 'value' =>
                $apk->cp_opd_nama || $apk->cp_opd_no_telepon
                    ? ($apk->cp_opd_nama ?? '-') . ' | ' . ($apk->cp_opd_no_telepon ?? '-')
                    : '-'
            ],
            ['label' => 'Contact Person Pengembang', 'value' =>
                $apk->cp_pengembang_nama || $apk->cp_pengembang_no_telepon
                    ? ($apk->cp_pengembang_nama ?? '-') . ' | ' . ($apk->cp_pengembang_no_telepon ?? '-')
                    : '-'
            ],
        ]
    ],
    'technical' => [
        'title' => 'Informasi Hosting',
        'icon' => 'bx-server',
        'data' => [
            ['label' => 'Server Hosting', 'value' => $apk->server ?? '-'],
            ['label' => 'Status Server', 'value' => $apk->status_server ?? '-'],
            ['label' => 'Open Akses', 'value' => $apk->open_akses ?? '-'],
            ['label' => 'Close Akses', 'value' => $apk->close_akses ?? '-'],
            ['label' => 'Urgensi', 'value' =>  $apk->urgensi ?? '-'],

        ]
    ],
    'additional' => [
        'title' => 'Informasi Tambahan',
        'icon' => 'bx-info',
        'data' => [
            ['label' => 'Keterangan', 'value' => $apk->keterangan ?? '-'],
            ['label' => 'Last Update', 'value' => $apk->last_update ?? '-'],
            ['label' => 'Surat Permohonan', 'value' => isset($riwayatRevisiAssessment->surat_permohonan) ? '<a href="' . asset('storage/' . $riwayatRevisiAssessment->surat_permohonan) . '" target="_blank" class="text-red-600"><i class="bx bxs-file-pdf mr-1"></i>Lihat Dokumen</a>' : '-'],
            ['label' => 'Catatan Admin', 'value' => $riwayatRevisiAssessment->catatan ?? '-'],
        ]
    ]
];

// Tambahkan ini untuk mencegah error undefined variable
if (!isset($riwayatPengembangan)) {
    $riwayatPengembangan = collect();
}

$lastPenilaian = $apk->penilaian->sortByDesc('created_at')->first();

$timelineData = [
    ['date' => $apk->permohonan, 'event' => 'Permohonan Diajukan', 'status' => 'completed'],
    ['date' => $apk->laporan_perbaikan, 'event' => 'Laporan Perbaikan', 'status' => $apk->laporan_perbaikan ? 'completed' : 'pending'],
    ['date' => $apk->updated_at, 'event' => 'Assessment Terakhir', 'status' => 'current'],
    ['date' => $apk->undangan_terakhir, 'event' => 'Undangan Terakhir', 'status' => $apk->tanggal_masuk_ba ? 'completed' : 'pending'],
    ['date' => $lastPenilaian?->created_at, 'event' => 'Penilaian Terakhir', 'status' => $lastPenilaian ? 'completed' : 'pending'],
    ['date' => $apk->tanggal_masuk_ba, 'event' => 'Masuk Berita Acara', 'status' => $apk->tanggal_masuk_ba ? 'completed' : 'pending'],
];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header dengan Action Buttons -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $apk->nama ?? 'Aplikasi' }}</h1>
                <div class="flex items-center space-x-4">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ strpos(strtolower($apk->status_label ?? ''), 'approved') !== false ? 'bg-green-100 text-green-800' :
                           (strpos(strtolower($apk->status_label ?? ''), 'pending') !== false ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $apk->status_label ?? 'Status Tidak Diketahui' }}
                    </span>
                    @if($apk->urgensi)
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">{{ $apk->urgensi }}</span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('rekap-aplikasi.edit', $apk->id) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    <i class="bx bxs-edit mr-1"></i> Edit
                </a>
                <form id="delete-form-{{ $apk->id }}" action="{{ route('rekap-aplikasi.destroy', $apk->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                </form>

                <button type="button"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors delete-btn"
                        data-form-id="delete-form-{{ $apk->id }}">
                    <i class="bx bxs-trash mr-1"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Main Assessment Info - Grid Layout -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="bx bx-info-circle mr-2 text-blue-600"></i>
                Informasi Utama
            </h3>
            <dl class="space-y-3">
                @foreach($mainAssessmentData as $item)
                    <div class="{{ $item['highlight'] ?? false ? 'bg-blue-50 p-3 rounded-md' : '' }}">
                        <dt class="text-sm font-large black">{{ $item['label'] }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 {{ $item['highlight'] ?? false ? 'font-semibold' : '' }}">
                            {!! $item['value'] !!}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <!-- Timeline Progress -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="bx bx-time mr-2 text-green-600"></i>
                Progress Timeline
            </h3>
            <div class="space-y-4">
                @foreach($timelineData as $timeline)
                    @if($timeline['date'])
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-3 h-3 rounded-full
                                {{ $timeline['status'] === 'completed' ? 'bg-green-500' :
                                   ($timeline['status'] === 'current' ? 'bg-blue-500' : 'bg-gray-300') }}">
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $timeline['event'] }}</p>
                                <p class="text-xs text-gray-500">{{ $timeline['date'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

<!-- Collapsible Detail Sections -->
    <div class="mb-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Detail Informasi</h3>
            <button id="toggleAllSections"
                    onclick="toggleAllSections()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                <i class="bx bx-expand-alt mr-1" id="toggleAllIcon"></i>
                <span id="toggleAllText">Expand All</span>
            </button>
        </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach($detailSections as $key => $section)
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-4 border-b cursor-pointer" onclick="toggleSection('{{ $key }}')">
                    <h4 class="font-medium text-gray-900 flex items-center justify-between">
                        <span><i class="bx {{ $section['icon'] }} mr-2 text-gray-600"></i>{{ $section['title'] }}</span>
                        <i class="bx bx-chevron-down transition-transform" id="chevron-{{ $key }}"></i>
                    </h4>
                </div>
                <div id="section-{{ $key }}" class="hidden p-4">
                    <dl class="space-y-2">
                        @foreach($section['data'] as $item)
                            <div>
                                <dt class="text-xs font-medium text-gray-600">{{ $item['label'] }}</dt>
                                <dd class="text-sm text-gray-900">{!! $item['value'] !!}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabs for Historical Data -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="border-b">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button class="tab-button active border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600"
                        onclick="showTab('penilaian')">
                    Riwayat Penilaian ({{ count($apk->penilaian ?? []) }})
                </button>
                <button class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                        onclick="showTab('undangan')">
                    Undangan Meeting ({{ count($apk->undangan ?? []) }})
                </button>
                <button class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                        onclick="showTab('revisi')">
                    Riwayat Revisi Assessment ({{ count($apk->riwayatRevisiAssessments ?? []) }})
                </button>
                <button class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                        onclick="showTab('pengembangan')">
                    Riwayat Pengembangan Aplikasi ({{ count($riwayatPengembangan ?? []) }})
                </button>
                <button class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700"
                        onclick="showTab('assessment-history')">
                    Detail Riwayat Assessment
                </button>
            </nav>
        </div>

        <!-- Penilaian Tab -->
        <div id="tab-penilaian" class="tab-content p-6">
            @if(count($apk->penilaian ?? []) > 0)
                <div class="space-y-4">
                    @foreach($apk->penilaian as $penilaian)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h5 class="font-medium text-gray-900">Hasil Penilaian : {{ str_replace('_', ' ', ucwords($penilaian->keputusan_assessment)) }}</h5>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Tanggal Penilaian Dibuat : {{ $penilaian->created_at ?? 'TBD' }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        @if($penilaian->tanggal_deadline_perbaikan)
                                            Tanggal Deadline Perbaikan : {{ \Carbon\Carbon::parse($penilaian->tanggal_deadline_perbaikan)->format('d F Y') }}
                                            @php
                                                $deadline = \Carbon\Carbon::parse($penilaian->tanggal_deadline_perbaikan);
                                            @endphp
                                            <small class="{{ $deadline->isPast() ? 'text-danger' : 'text-muted' }}">
                                                {{ $deadline->format('d F Y') }}
                                                ({{ $deadline->diffForHumans() }})
                                                @if($deadline->isPast())
                                                    - Melewati batas waktu
                                                @endif
                                            </small>
                                        @else
                                            <span class="text-muted">Tidak ditentukan</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($penilaian->dokumen_hasil_assessment)
                                        <a href="{{ asset('storage/' . $penilaian->dokumen_hasil_assessment) }}" target="_blank"
                                           class="text-red-600 hover:text-red-800">
                                            <i class="bx bxs-file-pdf text-xl"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('penilaian.show', $penilaian->id) }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        <i class="bx bxs-show text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada data penilaian</p>
            @endif
        </div>

        <!-- Undangan Tab -->
        <div id="tab-undangan" class="tab-content p-6 hidden">
            @if(count($apk->undangan ?? []) > 0)
                <div class="space-y-4">
                    @foreach($apk->undangan as $undangan)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h5 class="font-medium text-gray-900">Assessment {{ $undangan->tanggal_assessment ?? 'TBD' }}</h5>
                                    <div class="text-sm text-gray-600 mt-1 space-y-1">
                                        @if($undangan->tanggal_zoom_meeting)
                                            @php
                                                $tanggal = $undangan->tanggal_zoom_meeting;
                                                $waktu = $undangan->waktu_zoom_meeting ?? '00.00';

                                                $jamMulai = explode('-', $waktu)[0];
                                                $jamMulaiFormatted = str_replace('.', ':', $jamMulai);

                                                $datetime = \Carbon\Carbon::parse("$tanggal $jamMulaiFormatted");
                                            @endphp
                                            <p>
                                                Meeting: {{ $datetime->format('d F Y, H:i') }} ({{ $waktu }})
                                                <small class="{{ $datetime->isPast() ? 'text-danger' : 'text-muted' }}">
                                                    ({{ $datetime->diffForHumans() }})
                                                    @if($datetime->isPast())
                                                        - Melewati jadwal meeting
                                                    @endif
                                                </small>
                                            </p>
                                        @endif
                                        @if($undangan->tempat)
                                            <p>Tempat: {{ $undangan->tempat }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($undangan->surat_undangan)
                                        <a href="{{ asset('storage/' . $undangan->surat_undangan) }}" target="_blank"
                                           class="text-red-600 hover:text-red-800">
                                            <i class="bx bxs-file-pdf text-xl"></i>
                                        </a>
                                    @endif
                                    @if($undangan->surat_undangan)
                                        <a href="{{ route('undangan.edit', $undangan->id) }}"
                                            <i class="bx bxs-edit text-xl"></i>
                                        </a>
                                    @endif
                                    @if($undangan->link_zoom_meeting)
                                        <a href="{{ $undangan->link_zoom_meeting }}" target="_blank"
                                           class="text-blue-600 hover:text-blue-800">
                                            <i class="bx bxs-video text-xl"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada data undangan</p>
            @endif
        </div>

        <!-- Revisi Tab -->
        <div id="tab-revisi" class="tab-content p-6 hidden">
            @if(count($apk->riwayatRevisiAssessments ?? []) > 0)
                <div class="space-y-4">
                    @foreach($apk->riwayatRevisiAssessments->sortByDesc('permohonan') as $revisi)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h5 class="font-medium text-gray-900">Revisi {{ $revisi->permohonan ?? 'TBD' }}</h5>
                                    <p class="text-sm text-gray-600 mt-1">{{ $revisi->catatan ?? 'Tidak ada catatan' }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($revisi->surat_permohonan)
                                        <a href="{{ asset('storage/' . $revisi->surat_permohonan) }}" target="_blank"
                                           class="text-red-600 hover:text-red-800">
                                            <i class="bx bxs-file-pdf text-xl"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('riwayat.show', $revisi->id) }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        <i class="bx bxs-show text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada riwayat revisi assessment</p>
            @endif
        </div>

        <!-- Riwayat Pengembangan Tab -->
        <div id="tab-pengembangan" class="tab-content p-6 hidden">
            @if(count($riwayatPengembangan ?? []) > 0)
                <div class="space-y-4">
                    @foreach($riwayatPengembangan as $riwayat)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h5 class="font-medium text-gray-900">{{ $riwayat->jenis ?? 'Pengembangan' }}</h5>
                                    <div class="text-sm text-gray-600 mt-1 space-y-1">
                                        <p><strong>Tanggal:</strong> {{ $riwayat->permohonan ?? '-' }}</p>
                                        <p><strong>Status:</strong> {{ $riwayat->status_label ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.show-apk', $riwayat->id) }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        <i class="bx bxs-show text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada riwayat pengembangan</p>
            @endif
        </div>

        <!-- Detail Riwayat Assessment Tab -->
        <div id="tab-assessment-history" class="tab-content p-6 hidden">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h5 class="font-medium text-gray-900 mb-3 flex items-center">
                        <i class="bx bx-calendar mr-2 text-blue-600"></i>
                        Timeline Assessment
                    </h5>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Tanggal Permohonan</dt>
                            <dd class="text-sm text-gray-900">{{ $apk->permohonan ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Tanggal Laporan Perbaikan</dt>
                            <dd class="text-sm text-gray-900">{{ $apk->laporan_perbaikan ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Assessment Terakhir</dt>
                            <dd class="text-sm text-gray-900">{{ $apk->updated_at ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Undangan Terakhir</dt>
                            <dd class="text-sm text-gray-900">{{ $apk->undangan_terakhir ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Tanggal Masuk BA</dt>
                            <dd class="text-sm text-gray-900">{{ $apk->tanggal_masuk_ba ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h5 class="font-medium text-gray-900 mb-3 flex items-center">
                        <i class="bx bx-note mr-2 text-green-600"></i>
                        Catatan & Status
                    </h5>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Keterangan</dt>
                            <dd class="text-sm text-gray-900">{{ $apk->keterangan ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Deskripsi Last Update</dt>
                            <dd class="text-sm text-gray-900">{{ $apk->last_update ?? '-' }}</dd>
                        </div>
                        {{-- <div>
                            <dt class="text-sm font-medium text-gray-700">Urgensi</dt>
                            <dd class="text-sm text-gray-900">
                                @if($apk->urgensi)
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">{{ $apk->urgensi }}</span>
                                @else
                                    -
                                @endif
                            </dd>
                        </div> --}}
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('admin.daftar-pengajuan-assessment') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
            <i class="bx bx-arrow-back mr-1"></i> Kembali
        </a>
    </div>
</div>

<script>
let allSectionsExpanded = false;

function toggleSection(sectionId) {
    const section = document.getElementById('section-' + sectionId);
    const chevron = document.getElementById('chevron-' + sectionId);

    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        chevron.classList.add('rotate-180');
    } else {
        section.classList.add('hidden');
        chevron.classList.remove('rotate-180');
    }

    // Update the toggle all button state based on current sections
    updateToggleAllButton();
}

function toggleAllSections() {
    const sections = ['access', 'contact', 'technical', 'additional'];
    const toggleAllText = document.getElementById('toggleAllText');
    const toggleAllIcon = document.getElementById('toggleAllIcon');

    allSectionsExpanded = !allSectionsExpanded;

    sections.forEach(sectionId => {
        const section = document.getElementById('section-' + sectionId);
        const chevron = document.getElementById('chevron-' + sectionId);

        if (allSectionsExpanded) {
            // Expand all
            section.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            // Collapse all
            section.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    });

    // Update button text and icon
    if (allSectionsExpanded) {
        toggleAllText.textContent = 'Collapse All';
        toggleAllIcon.className = 'bx bx-collapse-alt mr-1';
    } else {
        toggleAllText.textContent = 'Expand All';
        toggleAllIcon.className = 'bx bx-expand-alt mr-1';
    }
}

function updateToggleAllButton() {
    const sections = ['access', 'contact', 'technical', 'additional'];
    const toggleAllText = document.getElementById('toggleAllText');
    const toggleAllIcon = document.getElementById('toggleAllIcon');

    // Check if all sections are expanded
    const expandedSections = sections.filter(sectionId => {
        const section = document.getElementById('section-' + sectionId);
        return !section.classList.contains('hidden');
    });

    allSectionsExpanded = expandedSections.length === sections.length;

    // Update button text and icon based on current state
    if (allSectionsExpanded) {
        toggleAllText.textContent = 'Collapse All';
        toggleAllIcon.className = 'bx bx-collapse-alt mr-1';
    } else {
        toggleAllText.textContent = 'Expand All';
        toggleAllIcon.className = 'bx bx-expand-alt mr-1';
    }
}

function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    document.getElementById('tab-' + tabName).classList.remove('hidden');

    // Add active class to clicked button
    event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');
}
</script>

<style>
.rotate-180 {
    transform: rotate(180deg);
}
.transition-transform {
    transition: transform 0.2s ease-in-out;
}
</style>

@endsection
