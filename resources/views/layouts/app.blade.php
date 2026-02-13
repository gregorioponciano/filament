
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Layouts')</title>
    @vite(['resources/css/app.css'])
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<style>
    :root {

                    --bg-color: {{ $siteSetting->bg_color ?? '#C6B9FF' }};
                    --primary-color: {{ $siteSetting->primary_color ?? '#FFFFFF' }};
                    --secondary-color: {{ $siteSetting->secondary_color ?? '#44474c' }};
                    --card-primary: {{ $siteSetting->card_primary ?? '#00ffff' }};
                    --card-secondary: {{ $siteSetting->card_secondary ?? '#C4B5FD' }};
                    --link-primary: {{ $siteSetting->link_primary ?? '#ffff00' }};
                    --link-secondary: {{ $siteSetting->link_secondary ?? '#9333EA' }};
                    --h1-color: {{ $siteSetting->h1_color ?? '#111827' }};
                    --h2-color: {{ $siteSetting->h2_color ?? '#ffff00' }};
                    --h3-color: {{ $siteSetting->h3_color ?? '#ffff00' }};
                    --text-primary: {{ $siteSetting->text_primary ?? '#9e97a6' }};
                    --text-secondary: {{ $siteSetting->text_secondary ?? '#ffff00' }};
                    --text-price: {{ $siteSetting->text_price ?? '#F9C704' }};
                    --button-primary: {{ $siteSetting->button_primary ?? '#5550FE' }};
                    --button-secondary: {{ $siteSetting->button_secondary ?? '#5550FE' }};
                    --input-primary: {{ $siteSetting->input_primary ?? '#ffff00' }};
                    --input-secondary: {{ $siteSetting->input_secondary ?? '#C4B5FD' }};
                    --hover-primary: {{ $siteSetting->hover_primary ?? '#EAB308' }};
                    --hover-secondary: {{ $siteSetting->hover_secondary ?? '#0faa00' }};
                    --border-primary: {{ $siteSetting->border_primary ?? '#E5E7EB' }};
                    --border-secondary: {{ $siteSetting->border_secondary ?? '#C4B5FD' }};
                    --footer-color: {{ $siteSetting->footer_color ?? '#2E1065' }};
                    --footer-text-color: {{ $siteSetting->footer_text_color ?? '#EDE9FE' }};
                    --font-family: '{{ $siteSetting->font_family ?? 'Inter' }}', sans-serif;
    }
    body {
        box-sizing: border-box;
        margin: 0;
        padding: 0;

    }
</style>

</head>
<body style="background-color: var(--bg-color);">
        @yield('content')

</body>
</html>