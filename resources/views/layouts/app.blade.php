@php
    // OPD dan USER
    $colors = ["#dbf5f0", "#a4e5e0"];
    $gradient = "linear-gradient(135deg, {$colors[0]} 0%, {$colors[1]} 100%)";

    // ADMIN
    $colors2 = ["#e7ebed", "#cdccdc"];
    $gradient2 = "linear-gradient(135deg, {$colors2[0]} 0%, {$colors2[1]} 100%)";

    $role = Auth::check() ? Auth::user()->role : null;
    $background = in_array($role, ['user', 'opd']) ? $gradient : $gradient2;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <head>
        <title>Manajemen Aplikasi OPD</title>
        <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3176/3176361.png" type="image/png">
        </head>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Tambahkan stack styles -->
        @stack('styles')

        <style>
            .main-content {
            margin-left: var(--sb-width);
            padding: 1rem;
            transition: margin-left 0.5s ease-in-out;
            min-height: 100vh;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background: {{ $background }};">
        <main>
            <div class="main-content min-h-screen" style="background: {{ $background }} !important;">
                @include('layouts.navigation')

                <!-- Page Heading -->
                {{-- @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset --}}

                <!-- Sidebar -->
                @include('components.sidebar')

                <div style="margin-left: 15px; padding: 20px;">
                    @yield('content')
                </div>

                <!-- Page Content -->
                <main>
                    @if (!empty($slot))
                        {{ $slot }}
                    @else
                        <p></p>
                    @endif
                </main>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Tambahkan stack scripts -->
        @stack('scripts')
    </body>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk semua tombol delete
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const formId = this.getAttribute('data-form-id');
                const form = document.getElementById(formId);

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
                    cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
                    background: '#ffffff',
                    color: '#212529',
                    customClass: {
                        popup: 'shadow-lg',
                        title: 'fw-bold',
                        confirmButton: 'btn btn-danger me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form jika dikonfirmasi
                        form.submit();
                    }
                });
            });
        });
    });
    </script>
</html>
