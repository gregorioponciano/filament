
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Layouts')</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_left" />
</head>
<body class="bg-bg">
    
    <style>

        :root{
            
            --primary-color: {{ $siteSetting->primary_color ?? '#00ffff' }};
            --secondary-color: {{ $siteSetting->secondary_color ?? '#647fff' }};
            --text-color: {{ $siteSetting->text_color ?? '#212529' }};
            --bg-color: {{ $siteSetting->bg_color ?? '#0cdf00' }};
            --border-color: {{ $siteSetting->border_color ?? '#d1d5db' }};
            --link-color: {{ $siteSetting->link_color ?? '#3b82f6' }};
            --hover-color: {{ $siteSetting->hover_color ?? '#64748b' }};
            --footer-color: {{ $siteSetting->footer_color ?? '#d1d5db' }};
            --footer-text-color: {{ $siteSetting->footer_text_color ?? '#212529' }};
            --font-sans: {{ $siteSetting->font_family ?? 'Inter' }}', sans-serif;
        }
        
    </style>
        @yield('content')

</body>
</html>