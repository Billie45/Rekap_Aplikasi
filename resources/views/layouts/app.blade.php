<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .main-content {
            margin-left: var(--sb-width);
            padding: 1rem;
            transition: margin-left 0.5s ease-in-out;
            min-height: 100vh;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <main>
            <div class="main-content min-h-screen bg-gray-100">
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
    </body>
</html>
