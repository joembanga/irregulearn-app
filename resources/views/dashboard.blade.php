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
                        <div class="max-w-7xl mx-auto sm:px-8 lg:px-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-3  gap-6">

                                <div class="card-surface p-6 rounded-3xl shadow-sm border border-muted">
                                    <p class="text-sm font-medium text-muted uppercase">XP Disponibles</p>
                                    <p class="text-3xl font-black text-primary">
                                        {{ number_format($user->xp_balance) }}
                                    </p>
                                </div>

                                <div class="card-surface p-6 rounded-3xl shadow-sm border border-muted">
                                    <p class="text-sm font-medium text-muted uppercase">Série actuelle</p>
                                    <p class="text-3xl font-black text-warning">{{ $user->current_streak }} jours 🔥</p>
                                </div>

                                <div class="card-surface p-6 rounded-3xl shadow-sm border border-muted">
                                    <p class="text-sm font-medium text-muted uppercase">Niveau</p>
                                    <p class="text-3xl font-black text-primary">{{ $userLevel }}</p>
                                </div>

                            </div>

                            <div class="card-surface p-8 rounded-3xl shadow-sm border border-muted">
                                <div class="flex flex-col md:flex-row items-center gap-8">

                                    <div class="relative h-32 w-32 flex items-center justify-center">
                                        <svg class="h-full w-full" viewBox="0 0 36 36">
                                            <path class="text-muted" stroke-width="3" stroke="currentColor" fill="none"
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                            <path class="text-primary" stroke-width="3"
                                                stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round"
                                                stroke="currentColor" fill="none"
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        </svg>
                                        <span
                                            class="absolute text-xl font-black text-body">{{ round($progressPercent) }}%</span>
                                    </div>

                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold text-body mb-2">Ta maîtrise des verbes</h3>
                                        <p class="text-muted mb-4">Tu as appris
                                            <strong>{{ $learnedVerbsCount }}</strong> verbes sur un total de
                                            <strong>{{ $totalVerbs }}</strong>. Continue comme ça ! </p>
                                        <a href="{{ route('learn') }}"
                                            class="inline-flex items-center px-6 py-3 bg-primary text-surface font-bold rounded-xl hover:bg-primary/90 transition">
                                            Continuer l'apprentissage
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-surface p-8 rounded-3xl shadow-sm border border-muted mb-8">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-body flex items-center gap-2">
                                        <span>⭐</span> Mes derniers favoris
                                    </h3>
                                    @if($latestFavorites->count() > 0)
                                    <a href="{{ route('favorites') }}" class="text-primary font-bold text-sm hover:underline">
                                        Voir tout →
                                    </a>
                                    @endif
                                </div>
                            
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                                    @forelse($latestFavorites as $fav)
                                    @php $stats = $fav->getPopularityStats(); @endphp
                                    
                                    <a href="{{ route('verb', $fav->slug ?? '') }}"
                                        class="group relative p-4 bg-surface rounded-2xl border border-muted hover:border-primary hover:-translate-y-1 hover:shadow-xl transition-all duration-300 overflow-hidden">
                                    
                                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">
                                                {{ $stats['percentage'] }}% 🔥
                                            </span>
                                        </div>
                                    
                                        <p class="text-lg font-bold text-body group-hover:text-primary transition-colors">
                                            {{ $fav->infinitive }}
                                        </p>
                                    
                                        <div class="mt-3">
                                            @if($stats['friends_count'] > 0)
                                            <div class="flex -space-x-2 overflow-hidden">
                                                @foreach($stats['friends'] as $friend)
                                                <div title="{{ $friend->username }}"
                                                    class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-primary-10 flex items-center justify-center text-[10px] font-bold text-primary">
                                                    {{ substr($friend->username, 0, 1) }}
                                                </div>
                                                @endforeach
                                                @if($stats['friends_count'] > 3)
                                                <div
                                                    class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 text-[10px] font-bold text-muted ring-2 ring-white">
                                                    +{{ $stats['friends_count'] - 3 }}
                                                </div>
                                                @endif
                                            </div>
                                            <p class="text-[10px] text-muted mt-1 leading-tight">
                                                {{ $stats['friends_count'] }} ami(s) l'ont enregistré
                                            </p>
                                            @else
                                            <p class="text-[10px] text-muted italic">Populaire à {{ $stats['percentage'] }}%</p>
                                            @endif
                                        </div>
                                    </a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="card-surface p-8 rounded-3xl shadow-sm border border-muted mt-8">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-body">Mes classmates</h3>
                                    <a href="{{ route('leaderboard', ['filter' => 'friendships']) }}"
                                        class="text-primary font-bold text-sm hover:underline">
                                        Voir le classement →
                                    </a>
                                </div>
                                @php
                                $friends = auth()->user()->friends(); // Assure-toi d'avoir la relation dans User.php
                                @endphp
                                <div class="flex flex-wrap gap-4">
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
                                    <div class="flex items-center gap-4 text-muted italic text-sm">
                                        <p>Tu n'as pas encore de friendships. Trouve-les dans le classement !</p>
                                        <a href="{{ route('leaderboard') }}"
                                            class="px-4 py-2 bg-surface rounded-xl text-muted not-italic font-bold text-xs hover:bg-primary-10">Chercher</a>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="card-surface p-8 rounded-3xl shadow-sm border border-muted">
                                    <h4 class="text-lg font-bold mb-4">Objectif quotidien</h4>
                                    <div class="space-y-4">
                                        <div
                                            class="flex justify-between items-center p-4 bg-surface rounded-2xl border border-muted">
                                            <span class="font-medium">Nombre de verbes par jour</span>
                                            <span class="text-primary font-bold">{{ $user->daily_target }} verbes</span>
                                        </div>
                                        <p class="text-xs text-muted italic">Modifier l'objectif dans les paramètresdu
                                            profil.</p>
                                    </div>
                                </div>
                                <div class="bg-primary p-8 rounded-3xl shadow-xl text-surface relative overflow-hidden">
                                    <div class="relative z-10">
                                        <h4 class="text-lg font-bold mb-2">Prêt pour un test ?</h4>
                                        <p class="text-primary/30 mb-6 text-sm">
                                            Entraîne-toi sur tous les verbes que tu as déjà vus pour ne pas les oublier.
                                        </p>
                                        <a href="{{ route('learn') }}"
                                            class="btn-invert px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary-10 transition">
                                            Faire un quiz
                                        </a>
                                    </div>
                                    <div class="absolute -right-10 -bottom-10 text-9xl opacity-10">📖</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <livewire:dashboard />
                    </div>
                </x-app-layout>