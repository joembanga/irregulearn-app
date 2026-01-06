<x-app-layout>
    @php
    $isFriend = DB::table('friendships')
    ->where(function($q) use ($user) {
    $q->where('sender_id', auth()->id())->where('recipient_id', $user->id);
    })
    ->where('status', 'accepted')
    ->exists();
    @endphp

    @if($isFriend)
    <livewire:transfer-points :receiver="$user" />
    @endif

    <div class="py-12 bg-app min-h-screen">
        <div class="max-w-5xl mx-auto px-6 space-y-8">

            <!-- Hero Profile Section -->
            <div class="card-surface rounded-[2.5rem] p-8 md:p-12 shadow-xl border border-muted relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-primary/5 blur-3xl rounded-full -mr-20 -mt-20 group-hover:bg-primary/10 transition-colors duration-700">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-tr from-primary to-purple-600 rounded-full blur opacity-25 group-hover:opacity-40 transition duration-700">
                        </div>
                        <div
                            class="relative w-32 h-32 md:w-40 md:h-40 bg-surface rounded-full flex items-center justify-center text-5xl md:text-6xl text-primary font-black shadow-2xl border-4 border-surface overflow-hidden">
                            @if(!empty($user->avatar_code))
                            @php
                            $options = [];
                            parse_str($user->avatar_code, $options);
                            @endphp
                            <img src="{{ 'https://avataaars.io/?' . http_build_query($options) }}" alt="Avatar"
                                class="w-full h-full object-cover">
                            @else
                            {{ substr($user->username, 0, 1) }}
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left space-y-4">
                        <div>
                            <div
                                class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider mb-2">
                                {{ $user->level_name }}
                            </div>
                            <h1 class="text-4xl md:text-5xl font-black text-body tracking-tight uppercase">
                                {{ $user->username }}</h1>
                            <p class="text-muted font-medium mt-1">Maîtrise les verbes depuis
                                {{ $user->created_at->format('M Y') }}</p>
                        </div>

                        <div class="flex flex-wrap justify-center md:justify-start gap-3">
                            @if(auth()->id() !== $user->id)
                            <livewire:follow-button :user="$user" />
                            @endif
                            <button x-data="{ copied: false }"
                                @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-surface border border-muted text-body rounded-2xl font-bold text-sm hover:bg-muted/5 transition active:scale-95 shadow-sm">
                                <span x-show="!copied">🔗 Partager le profil</span>
                                <span x-show="copied" x-cloak class="text-success">✅ Lien copié !</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Streak Card -->
                <div
                    class="card-surface p-8 rounded-3xl border border-muted flex flex-col items-center justify-center text-center group hover:border-orange-400 transition-colors">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🔥</div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] mb-1">Série</p>
                    <p class="text-3xl font-black text-body">{{ $user->current_streak }} jours</p>
                </div>

                <!-- XP Card -->
                <div
                    class="card-surface p-8 rounded-3xl border border-muted flex flex-col items-center justify-center text-center group hover:border-primary transition-colors">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">⚡</div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] mb-1">XP Hebdo</p>
                    <p class="text-3xl font-black text-body">{{ number_format($user->xp_weekly) }}</p>
                </div>

                <!-- Verbs Card -->
                <div
                    class="card-surface p-8 rounded-3xl border border-muted flex flex-col items-center justify-center text-center group hover:border-purple-500 transition-colors">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">📖</div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] mb-1">Maîtrisés</p>
                    <p class="text-3xl font-black text-body">{{ $user->verb()->wherePivot('mastered', true)->count() }}
                    </p>
                </div>
            </div>

            <!-- Badges Section -->
            <div class="card-surface p-8 md:p-12 rounded-[2.5rem] border border-muted">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-2xl font-black text-body uppercase tracking-tighter">Collections de Badges</h3>
                    <span class="text-xs font-bold text-muted uppercase tracking-widest">{{ $user->badges->count() }}
                        débloqués</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
                    @forelse($user->badges as $badge)
                    <div class="group flex flex-col items-center">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-primary/20 blur-xl rounded-full scale-0 group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div
                                class="relative w-20 h-20 bg-surface border border-muted rounded-2xl flex items-center justify-center text-3xl shadow-sm group-hover:shadow-xl group-hover:-translate-y-2 transition-all duration-300">
                                {{ $badge->icon }}
                            </div>
                        </div>
                        <span
                            class="mt-4 text-[10px] font-black text-muted uppercase tracking-widest text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $badge->name }}
                        </span>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="text-5xl opacity-20 mb-4">🏆</div>
                        <p class="text-muted font-medium">En attente de ses premiers exploits...</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>