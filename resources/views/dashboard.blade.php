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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Daily Challenge Card (Prominent) -->
                <div class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-600 p-6 md:p-8 text-white shadow-xl">
                    <div class="relative z-10">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                            <div>
                                <h3 class="text-2xl md:text-3xl font-black mb-2">Défi Quotidien</h3>
                                <p class="text-indigo-100 mb-6 max-w-md text-sm md:text-base">
                                    Tes verbes du jour t'attendent. Maîtrise-les pour garder ta série en vie !
                                </p>
                            </div>
                            <div class="hidden sm:block text-5xl bg-white/10 p-4 rounded-2xl backdrop-blur-sm self-start">
                                📅
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center mt-4">
                            <a href="{{ route('learn.daily') }}"
                                class="w-full sm:w-auto justify-center group flex items-center gap-3 px-8 py-4 bg-white text-indigo-600 rounded-2xl font-black text-lg transition hover:scale-105 active:scale-95 shadow-lg shadow-indigo-900/20">
                                <span>C'est parti !</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>

                            <!-- Daily Verbs Preview -->
                            @php
                                $dailyVerbs = auth()->user()->dailyVerbs()->take(3)->get();
                            @endphp
                            <div class="flex ml-0 sm:ml-4 -space-x-3 mt-2 sm:mt-0">
                                @foreach ($dailyVerbs as $dv)
                                    <div class="h-10 px-4 bg-indigo-500/50 backdrop-blur-md rounded-full flex items-center justify-center border border-white/20 text-xs font-bold shadow-sm" title="{{ $dv->translation }}">
                                        {{ $dv->infinitive }}
                                    </div>
                                @endforeach
                                @if (auth()->user()->dailyVerbs()->count() > 3)
                                    <div class="h-10 w-10 bg-indigo-500/50 backdrop-blur-md rounded-full flex items-center justify-center border border-white/20 text-xs font-bold shadow-sm">
                                        +{{ auth()->user()->dailyVerbs()->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute top-10 right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl"></div>
                </div>

                <!-- Streak & Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-6">
                    <!-- Streak Card -->
                    @php
                        $timezone = auth()->user()->timezone ?? 'UTC';
                        $localToday = now()->setTimezone($timezone)->toDateString();
                        $lastActivity = auth()->user()->last_activity_local_date;
                        $lastActivityDate = $lastActivity ? \Carbon\Carbon::parse($lastActivity)->toDateString() : null;
                        $isDoneToday = $lastActivityDate === $localToday;
                    @endphp
                    <div class="card-surface p-6 rounded-3xl border border-muted flex items-center justify-between relative overflow-hidden group">
                        @if ($isDoneToday)
                            <div class="absolute right-0 top-0 w-32 h-32 bg-orange-500/20 blur-3xl rounded-full pointer-events-none"></div>
                        @endif
                        <div>
                            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Série en cours</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-4xl font-black {{ $isDoneToday ? 'text-orange-500' : 'text-body' }}">
                                    {{ auth()->user()->current_streak }}
                                </span>
                                <span class="text-sm font-bold text-muted">jours</span>
                            </div>
                        </div>
                        <div class="text-5xl transition-transform duration-300 group-hover:scale-110 {{ $isDoneToday ? 'grayscale-0' : 'grayscale opacity-50' }}">
                            🔥
                        </div>
                    </div>

                    <!-- XP Card -->
                    <div class="card-surface p-6 rounded-3xl border border-muted flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">XP Total</p>
                            <p class="text-3xl font-black text-primary">{{ number_format($user->xp_total) }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center text-2xl">
                            ⚡
                        </div>
                    </div>

                    <!-- Level Card -->
                    <div class="card-surface p-6 rounded-3xl border border-muted flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Niveau</p>
                            <p class="text-3xl font-black text-primary">{{ $userLevel }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center text-2xl">
                            🎓
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Target & Mastery Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Promoted Daily Target -->
                <div class="lg:col-span-2 card-surface p-8 rounded-[2.5rem] border-2 border-primary/20 bg-primary/5 relative overflow-hidden group">
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                        <div class="h-24 w-24 rounded-3xl bg-primary text-surface flex items-center justify-center text-4xl shadow-xl shadow-primary/30 group-hover:rotate-6 transition-transform">
                            🎯
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-black text-body mb-2 uppercase tracking-tight">Objectif du jour</h3>
                            <p class="text-muted text-sm mb-6 leading-relaxed">
                                Tu as choisi de maîtriser <span class="text-primary font-bold">{{ $user->daily_target }} verbes</span> aujourd'hui. <br class="hidden md:block"> Ta progression quotidienne est le moteur de ta réussite.
                            </p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                <a href="{{ route('verbs.today') }}" class="px-8 py-3 bg-primary text-surface rounded-2xl font-black text-sm hover:scale-105 transition shadow-lg active:scale-95">
                                    📋 VOIR MA LISTE DU JOUR
                                </a>
                                <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-surface border border-muted text-body rounded-2xl font-bold text-xs hover:bg-muted/10 transition">
                                    Modifier l'objectif
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 text-8xl opacity-[0.03] font-black pointer-events-none uppercase">Daily</div>
                </div>

                <!-- Shrinked Mastery Card -->
                <div class="card-surface p-8 rounded-[2.5rem] border border-muted flex flex-col items-center justify-center text-center relative overflow-hidden">
                    <div class="relative h-24 w-24 mb-4">
                        <svg class="h-full w-full" viewBox="0 0 36 36">
                            <path class="text-muted/20" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-primary" stroke-width="4" stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-xl font-black text-body leading-none">{{ round($progressPercent) }}%</span>
                        </div>
                    </div>
                    <h4 class="text-sm font-black text-body uppercase tracking-widest mb-1">Maîtrise Globale</h4>
                    <p class="text-[10px] font-bold text-muted uppercase">{{ $learnedVerbsCount }} / {{ $totalVerbs }} VERBES</p>
                    <a href="{{ route('learn.index') }}" class="mt-4 text-[10px] font-black text-primary hover:underline uppercase tracking-widest">Détails →</a>
                </div>
            </div>

            <!-- Favorites -->
            <div class="card-surface p-6 md:p-8 rounded-3xl shadow-sm border border-muted mb-8">
                <div class="flex flex-wrap justify-between items-center mb-6 gap-2">
                    <h3 class="text-lg md:text-xl font-bold text-body flex items-center gap-2">
                        <span>⭐</span> Mes derniers favoris
                    </h3>
                    @if ($latestFavorites->count() > 0)
                        <a href="{{ route('verbs.favorites') }}" class="text-primary font-bold text-[10px] hover:underline uppercase tracking-widest">
                            Voir tout →
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    @forelse($latestFavorites as $fav)
                        @php $stats = $fav->getPopularityStats(); @endphp

                        <a href="{{ route('verbs.show', $fav->slug ?? '') }}" class="group relative p-4 bg-surface rounded-2xl border border-muted hover:border-primary hover:-translate-y-1 hover:shadow-xl transition-all duration-300 overflow-hidden text-center sm:text-left">

                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">
                                    {{ $stats['percentage'] }}% 🔥
                                </span>
                            </div>

                            <p class="text-lg font-bold text-body group-hover:text-primary transition-colors">
                                {{ $fav->infinitive }}
                            </p>

                            <div class="mt-3 flex justify-center sm:justify-start">
                                @if ($stats['friends_count'] > 0)
                                    <div class="flex -space-x-2 overflow-hidden rounded-full">
                                        @foreach ($stats['friends'] as $friend)
                                            <div title="{{ $friend->username }}"
                                                class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-primary-10 flex items-center justify-center text-[10px] font-bold text-primary">
                                                {{ substr($friend->username, 0, 1) }}
                                            </div>
                                        @endforeach
                                        @if ($stats['friends_count'] > 3)
                                            <div
                                                class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 text-[10px] font-bold text-muted ring-2 ring-white">
                                                +{{ $stats['friends_count'] - 3 }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-2 text-left">
                                        <p class="text-[10px] text-muted mt-1 leading-tight">
                                            {{ $stats['friends_count'] }} ami{{ $stats['friends_count'] > 1 ? 's ont ajoutés' : ' a ajouté' }} ce verbe
                                        </p>
                                    </div>
                                @else
                                    <p class="text-[10px] text-muted italic">
                                        Favori de {{ $stats['percentage'] }}% des utilisateurs
                                    </p>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center text-muted italic">
                            Tu n'as pas encore de favoris. Ajoute des verbes à ta liste !
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Discovery & Social Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Discovery Card -->
                <div class="card-surface p-8 rounded-[2.5rem] border border-muted relative overflow-hidden flex flex-col justify-between min-h-[280px] group">
                    <div class="relative z-10">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-500 text-[10px] font-bold uppercase tracking-wider mb-4">
                            Nouveautés
                        </div>
                        <h3 class="text-2xl font-black text-body mb-3 tracking-tight">Explore l'écosystème</h3>
                        <p class="text-muted text-sm max-w-sm leading-relaxed mb-8">
                            Débloque de nouveaux thèmes dans la boutique ou recherche des verbes spécifiques pour approfondir tes connaissances.
                        </p>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('shop') }}" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 text-surface rounded-xl font-bold text-sm hover:scale-105 transition shadow-sm active:scale-95 group-hover:shadow-indigo-500/20">
                                🛒 La Boutique
                            </a>
                            <a href="{{ route('search') }}" class="flex items-center gap-2 px-5 py-3 bg-surface border border-muted text-body rounded-xl font-bold text-sm hover:bg-muted/10 transition active:scale-95">
                                🔍 Rechercher
                            </a>
                        </div>
                    </div>
                    <div class="absolute -right-6 -bottom-6 text-9xl opacity-5 rotate-12 pointer-events-none group-hover:rotate-0 transition-transform duration-700">✨</div>
                </div>

                <!-- Friends Section -->
                <div class="card-surface p-8 rounded-[2.5rem] border border-muted flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-black text-body flex items-center gap-2 uppercase tracking-tighter">
                                🤝 Mes classmates
                            </h3>
                            <a href="{{ route('leaderboard', ['filter' => 'friendships']) }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">Voir tout →</a>
                        </div>
                        
                        @php $friends = auth()->user()->friends(); @endphp
                        <div class="flex flex-wrap gap-4">
                            @forelse($friends as $friend)
                                <a href="{{ route('profile.public', $friend->username) }}" class="group flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-black border-2 border-transparent group-hover:border-primary transition shadow-sm mb-1 text-sm">
                                        {{ substr($friend->username, 0, 1) }}
                                    </div>
                                    <span class="text-[9px] font-bold text-muted group-hover:text-primary transition-colors lowercase tracking-tight">{{ $friend->username }}</span>
                                </a>
                            @empty
                                <div class="flex flex-col items-center justify-center w-full py-4 text-center">
                                    <p class="text-xs text-muted font-medium mb-4 italic">Seul on va vite, ensemble on va loin.</p>
                                    <a href="{{ route('leaderboard') }}" class="px-4 py-2 border border-muted rounded-xl text-[10px] font-black text-muted hover:bg-muted/10 transition uppercase tracking-widest">Trouver des amis</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-muted/50 flex items-center justify-between">
                        <div class="text-[10px] text-muted font-bold uppercase tracking-widest">Public Profile</div>
                        <a href="{{ route('profile.public', auth()->user()->username) }}" class="text-[10px] font-black text-primary hover:text-primary/80 transition-colors uppercase tracking-widest">
                            VOIR MON PROFIL →
                        </a>
                    </div>
                </div>
            </div>

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
                        <a href="{{ route('learn.index') }}" class="shrink-0 px-10 py-5 bg-white text-indigo-600 rounded-[2rem] font-black text-base hover:scale-105 transition shadow-2xl active:scale-95">
                            LANCER UN QUIZ ⚡
                        </a>
                    </div>
                    <div class="absolute -right-6 -bottom-6 text-[12rem] opacity-10 group-hover:rotate-12 transition-transform duration-700 pointer-events-none font-black text-white">TEST</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>