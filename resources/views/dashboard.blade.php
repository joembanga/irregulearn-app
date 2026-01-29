@section('title', __('Dashboard'))
@section('description', __('...'))
@section('keywords', '...')
@php
$user = auth()->user();
$latestFavorites = $user->favorites()
    ->with(['favoritedByUsers'])
    ->orderBy('stared_verbs.created_at', 'desc')
    ->take(5)
    ->get();
@endphp
<x-app-layout>
        <div class="py-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 md:mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-body">
                    {{ (+now($user->timezone)->get('hour') >= 5 && +now($user->timezone)->get('hour') < 18) ? __('Salut') : __('Bonsoir') }} <span class="text-primary">{{ $user->firstname }}</span> 👋
                </h1>
                <p class="text-muted font-medium mt-2 text-lg">
                    {{ __('Prêt à conquérir de nouveaux verbes aujourd\'hui ?') }}
                </p>
            </div>

            <div class="space-y-12">
                <!-- Stats Section -->
                @include('partials.dashboard.stats-section')

                <!-- Daily Target & Mastery Section -->
                @include('partials.dashboard.daily-target-and-mastery-section')

                <!-- Favorites -->
                @include('partials.dashboard.favorites-section')

                <!-- Discovery & Social Section -->
                @include('partials.dashboard.discovery-and-social-section')
            </div>
        </div>
</x-app-layout>