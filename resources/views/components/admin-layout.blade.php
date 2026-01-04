<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden md:flex flex-col">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <!-- Logo Placeholder -->
                <div class="h-8 w-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold">
                    A
                </div>
                <span class="font-bold text-xl text-gray-800 dark:text-gray-200">Admin</span>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" class="block px-4 py-2 rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</p>
                </div>

                <a href="{{ route('admin.verbs.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.verbs.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                    <span>Verbs</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                    <span>Users</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Moderation</p>
                </div>

                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                    <span>Reports</span>
                    <!-- Potential Badge Here -->
                </a>
            </nav>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to App
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile Header -->
            <header class="md:hidden flex items-center justify-between p-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="font-bold">Admin</div>
                <button class="text-gray-500">Menu</button> <!-- Simplified for now -->
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>

</html>