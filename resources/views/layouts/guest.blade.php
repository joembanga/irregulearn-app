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
    <body class="font-sans text-gray-900 dark:text-gray-200 antialiased app-bg">
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="relative max-w-4xl w-full">
                <div class="absolute -inset-6 blur-3xl opacity-30 pointer-events-none" style="background:linear-gradient(90deg,var(--color-primary),#9b6bff);filter:blur(40px);"></div>

                <div class="mx-auto w-full sm:max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl card-surface glass overflow-hidden">
                    <div class="px-6 py-8">
                        <div class="flex items-center justify-center mb-6">
                            <a href="/" class="flex items-center gap-3">
                                <x-application-logo class="h-10 w-10" />
                                <div>
                                    <div class="text-lg font-black text-gray-900 dark:text-white">IrreguLearn</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Maîtrise les verbes irréguliers</div>
                                </div>
                            </a>
                        </div>

                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
