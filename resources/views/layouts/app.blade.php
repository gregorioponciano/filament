@php
    use App\Models\SiteSetting;
    $siteSetting = SiteSetting::first();
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">

    {{-- Fonte dinâmica --}}
    <link
        href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $siteSetting->font_family ?? 'Inter') }}&display=swap"
        rel="stylesheet"
    >

    {{-- Variáveis globais --}}
    <style>
        :root {
            --primary-color: {{ $siteSetting->primary_color ?? '#2563eb' }};
            --font-sans: '{{ $siteSetting->font_family ?? 'Inter' }}', sans-serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    @yield('content')
</body>
</html>
