<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="{{ url('js/navbar.js') }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div x-data 
     x-init="
        let tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
        fetch('/user/timezone', { // J'ai retiré /api pour coller à la route web.php
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json', // Important pour dire à Laravel qu'on veut du JSON en cas d'erreur
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ timezone: tz })
        }).catch(error => console.error('Erreur:', error));
     " class="min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-300">
            {{-- @include('layouts.navigation') --}}
            <x-navbar />

            <!-- Page Content -->
            <main class="pt-20">
                {{ $slot }}
            </main>
        </div>
        @include('layouts.footer')
        {{-- <script>
            window.addEventListener('notify', event => {
                // Tu peux utiliser une bibliothèque comme SweetAlert2 ou juste un toast custom
                alert(event.detail.message); 
                // Ou un toast plus élégant :
                // toastr[event.detail.type](event.detail.message);
            });
        </script> --}}
        @livewireScripts
    </body>
</html>
