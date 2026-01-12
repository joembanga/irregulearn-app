<x-admin-layout>
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h1>
        <p class="text-sm text-gray-500">{{ now()->format('l, jS F Y') }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-soft border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Users</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['users'] }}</h3>
                </div>
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-500 font-semibold flex items-center">
                    +{{ $stats['new_users_today'] }}
                </span>
                <span class="text-gray-400 ml-2">joined today</span>
            </div>
        </div>

        <!-- Total Verbs -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-soft border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Verbs</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['verbs'] }}</h3>
                </div>
                <div class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="{{ route('admin.verbs.index') }}" wire.navigate class="text-primary hover:underline">Manage verbs &rarr;</a>
            </div>
        </div>

        <!-- Reports -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-soft border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pending Reports</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['reports'] }}</h3>
                </div>
                <div class="p-2 {{ $stats['reports'] > 0 ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400' : 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' }} rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if($stats['reports'] > 0)
                <a href="{{ route('admin.reports.index') }}" wire.navigate class="text-red-500 font-semibold hover:underline">Review required &rarr;</a>
                @else
                <span class="text-green-500">All caught up!</span>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>