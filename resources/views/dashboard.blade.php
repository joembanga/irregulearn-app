@php
    $user = auth()->user();

    // On charge les verbes favoris ET les utilisateurs qui les aiment en une seule fois
    $latestFavorites = $user->favorites()
        ->with(['favoritedByUsers'])
        ->orderBy('stared_verbs.created_at', 'desc')
        ->take(5)
        ->get();
@endphp
<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-8 lg:px-8">
        <div class="py-6">
            <h2 class="font-semibold text-xl text-body leading-tight">
                {{ __('Heureux de te revoir') }} {{ $user->firstname }}
            </h2>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Daily Challenge & Stats Section -->
            @include('partials.dashboard.daily-challenge-and-stats-section')

            <!-- Daily Target & Mastery Section -->
            @include('partials.dashboard.daily-target-and-mastery-section')

            <!-- Favorites -->
            @include('partials.dashboard.favorites-section')

            <!-- Discovery & Social Section -->
            @include('partials.dashboard.discovery-and-social-section')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-12">
                <!-- Promo Flash Test -->
                <div class="lg:col-span-2 bg-indigo-600 p-8 md:p-12 rounded-[2.5rem] shadow-xl text-surface relative overflow-hidden group">
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="text-center md:text-left">
                            <h4 class="text-white text-3xl font-black mb-4 tracking-tight uppercase">Prêt pour un test éclair ?</h4>
                            <p class="text-indigo-100 text-base max-w-xl leading-relaxed opacity-90 font-medium">
                                Entraîne-toi sur tous les verbes que tu as déjà vus pour bétonner tes connaissances. Une session de 5 minutes suffit pour tout changer.
                            </p>
                        </div>
                        <a href="{{ route('learn.know-verbs') }}" class="shrink-0 px-10 py-5 bg-white text-indigo-600 rounded-[2rem] font-black text-base hover:scale-105 transition shadow-2xl active:scale-95">
                            LANCER UN QUIZ ⚡
                        </a>
                    </div>
                    <div class="absolute -right-6 -bottom-6 text-[12rem] opacity-10 group-hover:rotate-12 transition-transform duration-700 pointer-events-none font-black text-white">TEST</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>