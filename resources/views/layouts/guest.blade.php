<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-body antialiased bg-gray-50/50">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="flex flex-col items-center mb-10">
                <a href="/" class="flex items-center gap-3">
                    <x-application-logo />
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                <div class="px-8 py-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>