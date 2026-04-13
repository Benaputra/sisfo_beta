<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SISFO FPST UPB') }} — @yield('title', 'Login')</title>
    <meta name="description" content="Portal Akademik The Fluid Scholar — Sistem Informasi Akademik">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
    @stack('styles')
</head>
<body>
    @yield('content')

    @stack('scripts')
</body>
</html>
