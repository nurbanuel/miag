@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ? $title . ' | MİARGEM' : 'MİARGEM | Mahalli İdarelerin Araştırma, Politika ve Kurumsal Kapasite Merkezi' }}</title>
    <meta name="description" content="{{ __('Belediye yöneticileri, çalışanları, akademisyenler ve yerel yönetim uzmanları için bağımsız araştırma, yayın, veri ve katılım merkezi.') }}" />
    <link rel="icon" href="data:," />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    {{ $head ?? '' }}
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-navy-900 antialiased">
    <x-header />

    <main id="main-content" class="flex-1">
        {{ $slot }}
    </main>

    <x-site-footer />

    {{ $scripts ?? '' }}
    @livewireScripts
</body>
</html>
