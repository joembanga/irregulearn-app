<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="fancy-scroll">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="manifest" href="{{ asset("/manifest.json") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Irregulearn - ' . __('Maitrise Les verbes Irreguliers Anglais'))</title>
    <meta name="description" content="@yield('description', __('Maîtrise les verbes irréguliers anglais avec IrreguLearn !'))">
    <meta name="author" content="Irregulearn">
    <meta name="keywords" content="@yield('keywords', '...')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="@yield('og_title', config('app.name', 'Irregulearn'))">
    <meta property="og:description" content="@yield('og_description', __('Maîtrise les verbes irréguliers anglais avec IrreguLearn !'))">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="IrreguLearn" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('og_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('og_description', __('Maîtrise les verbes irréguliers anglais avec IrreguLearn !'))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.png'))">
    <meta  rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased no-transitions">
    <div x-data="{
            sidebarOpen: localStorage.getItem('sidebarOpen') !== null
                ? localStorage.getItem('sidebarOpen') === 'true'
                : window.innerWidth >= 1024,
            isDark: document.documentElement.classList.contains('dark'),
            init() {
                this.$watch('sidebarOpen', value => {
                    localStorage.setItem('sidebarOpen', value);
                });

                const TIMEZONE_CACHE_KEY = 'userTimezone';
                const TIMEZONE_TIMESTAMP_KEY = 'userTimezoneTimestamp';
                const WEEK_IN_MS = 7 * 24 * 60 * 60 * 1000;

                const checkAndUpdateTimezone = () => {
                    const cachedTz = localStorage.getItem(TIMEZONE_CACHE_KEY);
                    const cachedTimestamp = localStorage.getItem(TIMEZONE_TIMESTAMP_KEY);
                    const currentTz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                    const now = Date.now();

                    const isCacheValid = cachedTimestamp &&
                        (now - parseInt(cachedTimestamp)) < WEEK_IN_MS &&
                        cachedTz === currentTz;

                    if (isCacheValid) {
                        return;
                    }

                    localStorage.setItem(TIMEZONE_CACHE_KEY, currentTz);
                    localStorage.setItem(TIMEZONE_TIMESTAMP_KEY, now.toString());
                    fetch('/user/timezone', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ timezone: currentTz })
                    }).catch(error => console.error('Erreur lors de la sauvegarde du timezone:', error));
                };
                checkAndUpdateTimezone();

                // Handle window resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024 && !this.sidebarOpen) {
                        this.sidebarOpen = true;
                    }
                });
            },
            toggleTheme() {
                this.isDark = !this.isDark;
                if (this.isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            }
         }" x-cloak class="min-h-screen bg-app text-body transition-colors duration-300">
        @include('layouts.navigation')
        @include('layouts.sidebar')

        <div x-bind:class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-32 md:mr-auto lg:mr-32'"
            class="min-h-screen flex flex-col transition-all duration-300"
            x-bind:style="window.innerWidth >= 1024 && sidebarOpen ? 'margin-left: 16rem' : ''">
            <!-- Messages -->
            @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                class="fixed bottom-6 right-6 z-50 bg-green-500/90 backdrop-blur-md text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce-in">
                <x-lucide-check-circle class="size-6" />
                <div class="font-bold">{{ session('success') }}</div>
            </div>
            @endif
            
            @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                class="fixed bottom-6 right-6 z-50 bg-red-500/90 backdrop-blur-md text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-shake">
                <x-lucide-alert-circle class="size-6" />
                <div class="font-bold">{{ session('error') }}</div>
            </div>
            @endif
            <!-- Page Content -->
            <main class="mt-32 md:mt-20 grow px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </main>
            @include('layouts.footer')
        </div>
    </div>
    <script>
        window.addEventListener('load', () => {
                document.body.classList.remove('no-transitions');
            });
            document.addEventListener('livewire:navigated', () => {
                document.body.classList.remove('no-transitions');
            });
            if (localStorage.getItem("color-theme") === "dark" ||
                (!("color-theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)
                ) {
                    document.documentElement.classList.add("dark");
                } else {
                    document.documentElement.classList.remove("dark");
                }
    </script>
    @livewireScripts
</body>

</html>