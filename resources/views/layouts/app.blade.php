<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-kawaii">
    @if(Auth::check())
    <div style="position: absolute; top: 1rem; right: 1rem; z-index: 1000;">
        <img src="{{ Auth::user()->image ?? asset('images/default-user.png') }}"
            alt="ユーザーアイコン"
            style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid #ccc;">
    </div>
    @endif
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
        <main class="px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>


</body>

</html>