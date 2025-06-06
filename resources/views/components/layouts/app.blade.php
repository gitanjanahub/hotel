<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }} | {{ env('APP_NAME') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">


    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('fronttheme/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/flaticon.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fronttheme/css/style.css') }}" type="text/css">

    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    @livewireStyles
</head>
<body>

    @livewire('sections.topbar')
    @livewire('sections.navbar')

    {{ $slot }}

    @livewire('sections.footer')

    <!-- JS Plugins -->
    <script src="{{ asset('fronttheme/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('fronttheme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('fronttheme/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('fronttheme/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('fronttheme/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('fronttheme/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('fronttheme/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('fronttheme/js/main.js') }}"></script>




    @livewireScripts
    @livewireScriptConfig
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <livewire:wire-elements-modal /> --}}
<livewire:auth.login-page/>
</body>
</html>
