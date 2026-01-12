<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Irregulearn') }}</title>

        <!-- Dynamic Meta Tags (Open Graph / SEO) -->
        <meta property="og:title" content="@yield('og_title', config('app.name'))">
        <meta property="og:description" content="@yield('og_description', 'Maîtrise les verbes irréguliers anglais avec IrreguLearn !')">
        <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('og_title', config('app.name'))">
        <meta name="twitter:description" content="@yield('og_description', 'Maîtrise les verbes irréguliers anglais avec IrreguLearn !')">
        <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.png'))">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @livewireStyles

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased no-transitions">
        <div x-data
     x-init="
        let tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
        fetch('/user/timezone', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ timezone: tz })
        }).catch(error => console.error('Erreur:', error));
     " class="min-h-screen bg-app text-body transition-colors duration-300">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="pt-20">
                {{ $slot }}
            </main>
        </div>
        @include('layouts.footer')
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
                function nav() {
                    return {
                        open: false,
                        isDark: document.documentElement.classList.contains("dark"),
                        init() {
                            this.isDark = document.documentElement.classList.contains("dark");
                        },
                        toggleTheme() {
                            this.isDark = !this.isDark;
                            if (this.isDark) {
                                document.documentElement.classList.add("dark");
                                localStorage.setItem("color-theme", "dark");
                            } else {
                                document.documentElement.classList.remove("dark");
                                localStorage.setItem("color-theme", "light");
                            }
                        },
                    };
                }
        </script>
        @livewireScripts
    </body>
</html>
