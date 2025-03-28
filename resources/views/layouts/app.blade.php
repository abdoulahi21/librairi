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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>

                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
                <!-- Icône du panier flottante en bas à droite -->
                @can('is-client')
                <li class="nav-item position-fixed bottom-10 end-10 m-5">
                    <a href="{{ route('cart.index') }}" class="nav-link position-relative bg-light shadow p-2 rounded-circle">
                        🛒
                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                         {{ session('cart') ? count(session('cart')) : 0 }}
                       </span>
                    </a>
                </li>
                @endcan
            </main>
        </div>
    </body>
</html>
