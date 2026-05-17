<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

@php
    $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    $cssFile = $manifest['resources/css/app.css']['file'] ?? 'app.css';
@endphp

<link rel="stylesheet" href="{{ asset('build/'.$cssFile) }}?v={{ time() }}">

<script src="/js/app.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<style>
    :root {
        --bg-primary: {{ $siteSetting->bg_color ?? '#FFFFFF' }};
        --bg-secundary: {{ $siteSetting->bg_secondary ?? '#000000' }};
        --primary-color: {{ $siteSetting->primary_color ?? '#FFFFFF' }};
        --secondary-color: {{ $siteSetting->secondary_color ?? '#000000' }};
        --menu-primary: {{ $siteSetting->menu_primary ?? '#FFFFFF' }};
        --menu-secondary: {{ $siteSetting->menu_secondary ?? '#000000' }};
        --card-primary: {{ $siteSetting->card_primary ?? '#FFFFFF' }};
        --card-secondary: {{ $siteSetting->card_secondary ?? '#000000' }};
        --link-primary: {{ $siteSetting->link_primary ?? '#FFFFFF' }};
        --link-secondary: {{ $siteSetting->link_secondary ?? '#000000' }};
        --h1-primary: {{ $siteSetting->h1_color ?? '#FFFFFF' }};
        --h1-secondary: {{ $siteSetting->h1_color ?? '#000000' }};
        --h2-primary: {{ $siteSetting->h2_color ?? '#000000' }};
        --h2-secondary: {{ $siteSetting->h2_color ?? '#FFFFFF' }};
        --h3-primary: {{ $siteSetting->h3_color ?? '#000000' }};
        --h3-secondary: {{ $siteSetting->h3_color ?? '#FFFFFF' }};
        --text-primary: {{ $siteSetting->text_primary ?? '#FFFFFF' }};
        --text-secondary: {{ $siteSetting->text_secondary ?? '#000000' }};
        --price-primary: {{ $siteSetting->text_price ?? '#FFFFFF' }};
        --price-secondary: {{ $siteSetting->text_price ?? '#000000' }};
        --button-primary: {{ $siteSetting->button_primary ?? '#1447E6' }};
        --button-secondary: {{ $siteSetting->button_secondary ?? '#F0B100' }};
        --input-primary: {{ $siteSetting->input_primary ?? '#FFFFFF' }};
        --input-secondary: {{ $siteSetting->input_secondary ?? '#0000000' }};
        --hover-primary: {{ $siteSetting->hover_primary ?? '#0B309A' }};
        --hover-secondary: {{ $siteSetting->hover_secondary ?? '#C79100' }};
        --border-primary: {{ $siteSetting->border_primary ?? '#FFF0FF' }};
        --border-secondary: {{ $siteSetting->border_secondary ?? '#000000' }};
        --footer-color: {{ $siteSetting->footer_color ?? '#FFFFFF' }};
        --footer-text-color: {{ $siteSetting->footer_text_color ?? '#000000' }};
        --font-family: '{{ $siteSetting->font_family ?? 'Inter' }}', sans-serif;
    }
    body {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: var(--font-family);
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes pulse-ring {
        0% { transform: scale(0.95); opacity: 0.7; }
        50% { transform: scale(1.05); opacity: 0.3; }
        100% { transform: scale(0.95); opacity: 0.7; }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .animate-fade-in-scale {
        animation: fadeInScale 0.4s ease-out forwards;
    }
    .animate-slide-in-right {
        animation: slideInRight 0.4s ease-out forwards;
    }
    .animate-shimmer {
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.4) 50%, transparent 100%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }
    .stagger-5 { animation-delay: 0.5s; }
    .stagger-6 { animation-delay: 0.6s; }
    .transition-fast {
        transition: all 0.15s ease-in-out;
    }
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .card-enter {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .card-enter.visible {
        opacity: 1;
        transform: translateY(0);
    }
    [x-cloak] { display: none !important; }
</style>
</head>
<body class="bg-primary">
    @yield('content')
</body>
</html>
