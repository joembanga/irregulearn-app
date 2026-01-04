<div class="py-12 max-w-5xl mx-auto px-4 sm:px-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="md:col-span-2 space-y-6">

            <div
                class="card-surface rounded-3xl p-8 shadow-xl flex flex-col sm:flex-row items-center sm:items-start gap-6 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500 rounded-full opacity-10 blur-3xl">
                </div>

                <div
                    class="h-24 w-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-surface text-3xl font-bold shadow-lg shrink-0">
                    {{ substr(strtoupper($user->username), 0, 1) }}
                </div>

                <div class="text-center sm:text-left flex-1">
                    <h1 class="text-3xl font-black text-body mb-2">{{ $user->username }}</h1>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-3">
                        <span
                            class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold uppercase tracking-wide">
                            Étudiant
                        </span>
                        <span
                            class="px-3 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 text-xs font-bold uppercase tracking-wide">
                            Inscrit depuis {{ $user->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-black text-indigo-600 dark:text-indigo-400">{{ number_format($user->xp) }}
                    </div>
                    <div class="text-xs text-muted uppercase font-bold tracking-wider">Points XP</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="card-surface p-6 rounded-2xl shadow-sm border border-muted">
                    <div class="text-muted text-sm font-medium mb-1">Classement</div>
                    <div class="text-2xl font-bold text-body">#{{ $rank }}</div>
                </div>

                <div class="card-surface p-6 rounded-2xl shadow-sm border border-muted">
                    <div class="text-muted text-sm font-medium mb-1">Verbes Maîtrisés</div>
                    <div class="text-2xl font-bold text-body">{{ $masteredCount }}</div>
                </div>
            </div>

            <div class="card-surface p-8 rounded-3xl shadow-sm border border-muted text-center py-12">
                <div class="text-4xl mb-4">📈</div>
                <h3 class="text-lg font-bold text-body">Progression</h3>
                <p class="text-muted text-sm">L'historique détaillé des activités sera bientôt disponible.</p>
            </div>
        </div>


        <div class="md:col-span-1">
            <div class="card-surface rounded-3xl shadow-lg border border-muted overflow-hidden sticky top-6">
                <div class="p-6 border-b border-muted bg-surface">
                    <h3 class="font-bold text-body flex items-center">
                        <span class="mr-2">🏆</span> Top Étudiants
                    </h3>
                </div>

                <div class="divide-y divide-muted">
                    @foreach($leaderboard as $player)
                    <a href="{{ route('profile.public', $player->username) }}"
                        class="flex items-center p-4 hover:bg-surface dark:hover:bg-gray-700 transition group">
                        <div
                            class="w-8 text-center font-bold {{ $loop->iteration <= 3 ? 'text-yellow-500' : 'text-muted' }}">
                            {{ $loop->iteration }}
                        </div>

                        <div
                            class="h-10 w-10 rounded-full bg-surface dark:bg-gray-600 flex items-center justify-center text-muted dark:text-gray-300 font-bold text-xs mx-3">
                            {{ substr(strtoupper($player->username), 0, 1) }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-body truncate group-hover:text-primary transition">
                                {{ $player->username }}
                            </div>
                            <div class="text-xs text-muted">{{ number_format($player->xp) }} XP</div>
                        </div>

                        @if($player->id === $user->id)
                        <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        @endif
                    </a>
                    @endforeach
                </div>

                <div class="p-4 text-center">
                    <p class="text-xs text-muted">Continue d'apprendre pour monter !</p>
                </div>
            </div>
        </div>

    </div>
</div>