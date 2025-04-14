<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ url('frontend/assets/images/logo/sinarmeadow.png') }}">

    <title>{{ 'CITA SMII' }} - @yield('title')</title>


    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('assets/') }}/css/styles.css">
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body class="hold-transition theme-primary bg-img bg-fixed"
    style="background-image: url({{ asset('frontend/assets/images/logo/pic.jpg') }}); background-size: 100% 100%; height: 100vh; width: 100vw;">

    <div class="px-4 md:px-0">
        <div class="grid grid-cols-1 m-0">
            {{ $slot }}
        </div>

        <!-- Import Js Files -->
        <script src="{{ asset('assets') }}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets') }}/libs/simplebar/dist/simplebar.min.js"></script>
        <script src="{{ asset('assets') }}/js/theme/app.horizontal.init.js"></script>
        <script src="{{ asset('assets') }}/js/theme/theme.js"></script>
        <script src="{{ asset('assets') }}/js/theme/app.min.js"></script>
        <script src="{{ asset('assets') }}/js/theme/feather.min.js"></script>

        <!-- solar icons -->
        <script src="{{ asset('assets/') }}npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>

</html>
