        @php
            use App\Models\SiteSetting;
            $siteSetting = SiteSetting::first();
        @endphp
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        
        @vite(['resources/css/app.css'])



    <style>
        :root {
            
            --primary-color: {{ $siteSetting->primary_color ?? '#3b82f6' }};
            --secondary-color: {{ $siteSetting->secondary_color ?? '#64748b' }};
            --text-color: {{ $siteSetting->text_color ?? '#212529' }};
            --bg-color: {{ $siteSetting->bg_color ?? '#f9fafb' }};
            --font-sans: '{{ $siteSetting->font_family ?? 'Inter' }}', sans-serif;
        }
    </style>
    
    </head>
    
    <body class="font-sans">
        @yield('content')
        </body>
        </html>
        