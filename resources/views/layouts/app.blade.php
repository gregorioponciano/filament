
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Layouts')</title>
{{-- Versão manual com timestamp --}}
@php
    $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    $cssFile = $manifest['resources/css/app.css']['file'] ?? 'app.css';
@endphp

<link rel="stylesheet" href="{{ asset('build/'.$cssFile) }}?v={{ time() }}">

<script src="/js/app.js"></script>
  
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

    }
</style>

</head>
<body class="bg-primary">
        @yield('content')

</body>
</html>