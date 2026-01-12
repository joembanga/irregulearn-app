<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-body antialiased app-bg">
    <div class="min-h-screen flex items-center justify-center py-6 lg:py-12 px-4 sm:px-6 lg:px-8">
        <div class="relative max-w-4xl w-full">
            <div
                class="mx-auto w-full sm:max-w-md rounded-2xl shadow-2xl card-surface glass overflow-hidden border border-muted/50">
                <div class="px-6 py-8">
                    <div class="flex items-center justify-center mb-6">
                        <a href="/" class="flex items-center gap-2">
                            <x-application-logo />
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>