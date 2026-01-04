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
                        $isDoneToday = auth()->user()->last_activity_local_date === $localToday;
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

            <div class="card-surface p-6 md:p-8 rounded-3xl shadow-sm border border-muted">
                <div class="flex flex-col md:flex-row items-center gap-6 md:gap-8 text-center md:text-left">

                    <div class="relative h-28 w-28 md:h-32 md:w-32 flex items-center justify-center shrink-0">
                        <svg class="h-full w-full" viewBox="0 0 36 36">
                            <path class="text-muted" stroke-width="3" stroke="currentColor" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-primary" stroke-width="3" stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <span class="absolute text-xl font-black text-body">{{ round($progressPercent) }}%</span>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-xl md:text-2xl font-bold text-body mb-2">Ta maîtrise des verbes</h3>
                        <p class="text-muted mb-4 text-sm md:text-base">Tu as appris
                            <strong>{{ $learnedVerbsCount }}</strong> verbes sur un total de
                            <strong>{{ $totalVerbs }}</strong>. Continue comme ça !
                        </p>
                        <a href="{{ route('learn') }}" class="inline-flex items-center px-6 py-3 bg-primary text-surface font-bold rounded-xl hover:bg-primary/90 transition w-full md:w-auto justify-center">
                            Continuer l'apprentissage
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-surface p-6 md:p-8 rounded-3xl shadow-sm border border-muted mb-8">
                <div class="flex flex-wrap justify-between items-center mb-6 gap-2">
                    <h3 class="text-lg md:text-xl font-bold text-body flex items-center gap-2">
                        <span>⭐</span> Mes derniers favoris
                    </h3>
                    @if ($latestFavorites->count() > 0)
                        <a href="{{ route('verbs.favorites') }}" class="text-primary font-bold text-sm hover:underline">
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
                                    <div class="flex -space-x-2 overflow-hidden">
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
                                            {{ $stats['friends_count'] }} ami(s)
                                        </p>
                                    </div>
                                @else
                                    <p class="text-[10px] text-muted italic">
                                        Populaire à {{ $stats['percentage'] }}%
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
            <div class="card-surface p-6 md:p-8 rounded-3xl shadow-sm border border-muted mt-8">
                <div class="flex flex-wrap justify-between items-center mb-6 gap-2">
                    <h3 class="text-lg md:text-xl font-bold text-body">Mes classmates</h3>
                    <a href="{{ route('leaderboard', ['filter' => 'friendships']) }}"
                        class="text-primary font-bold text-sm hover:underline">
                        Voir le classement →
                    </a>
                </div>
                @php
                    $friends = auth()->user()->friends();
                @endphp
                <div class="flex flex-wrap gap-4 items-center justify-center md:justify-start">
                    @forelse($friends as $friend)
                        <a href="{{ route('profile.public', $friend->username) }}"
                            class="group flex flex-col items-center">
                            <div
                                class="w-14 h-14 rounded-full bg-primary-10 flex items-center justify-center text-primary font-bold border-2 border-transparent group-hover:border-primary transition shadow-sm mb-2 text-lg">
                                {{ substr($friend->username, 0, 1) }}
                            </div>
                            <span
                                class="text-xs font-medium text-muted group-hover:text-primary">{{ $friend->username }}</span>
                        </a>
                    @empty
                        <div class="flex flex-col md:flex-row items-center gap-4 text-muted italic text-sm text-center md:text-left">
                            <p>Tu n'as pas encore de friendships. Trouve-les dans le classement !</p>
                            <a href="{{ route('leaderboard') }}" class="px-4 py-2 bg-surface rounded-xl text-muted not-italic font-bold text-xs hover:bg-primary-10 border border-muted">Chercher</a>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 pb-8">
                <div class="card-surface p-6 md:p-8 rounded-3xl shadow-sm border border-muted">
                    <h4 class="text-lg font-bold mb-4">Objectif quotidien</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-surface rounded-2xl border border-muted">
                            <span class="font-medium text-sm md:text-base">Verbes / jour</span>
                            <span class="text-primary font-bold">{{ $user->daily_target }}</span>
                        </div>
                        <p class="text-xs text-muted italic">Modifier l'objectif dans les paramètres du profil.</p>
                    </div>
                </div>
                <div class="bg-primary p-6 md:p-8 rounded-3xl shadow-xl text-surface relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-lg font-bold mb-2">Prêt pour un test ?</h4>
                        <p class="text-primary/30 mb-6 text-sm">
                            Entraîne-toi sur tous les verbes que tu as déjà vus pour ne pas les oublier.
                        </p>
                        <a href="{{ route('learn') }}"
                            class="btn-invert px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary-10 transition inline-block w-full text-center md:w-auto">
                            Faire un quiz
                        </a>
                    </div>
                    <div class="absolute -right-10 -bottom-10 text-9xl opacity-10 pointer-events-none">📖</div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <livewire:dashboard />
    </div>
</x-app-layout>