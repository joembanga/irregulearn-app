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
                <h1 class="text-3xl md:text-4xl font-bold text-body tracking-tighter">
                    {{ __('Salut,') }} <span class="text-primary">{{ $user->firstname }}</span> 👋
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 pb-12">
                    <!-- Promo Flash Test -->
                    <div class="md:col-span-2 bg-primary p-6 md:p-10 rounded-xl shadow-xl text-surface relative overflow-hidden group">
                        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                            <div class="text-center md:text-left">
                                <h4 class="text-white text-2xl font-bold mb-4 tracking-tight uppercase">
                                    Prêt pour un test éclair ?
                                </h4>
                                <p class="text-indigo-100 text-base max-w-xl leading-relaxed opacity-90 font-medium">
                                    Entraîne-toi sur tous les verbes que tu as déjà vus pour bétonner tes connaissances.
                                    Une session de 5 minutes suffit pour tout changer.
                                </p>
                            </div>
                            <a href="{{ route('learn.session', ['mode' => 'revision']) }}" wire:navigate
                                class="flex flex-nowrap items-center gap-2 shrink-0 px-10 py-5 bg-white text-primary rounded-xl font-bold text-base hover:scale-105 transition shadow-2xl active:scale-95">
                                <span>LANCER UN QUIZ</span>
                                <span><x-lucide-brain class="size-6 inline" /></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>