<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Discovery Card -->
    <div class="card-surface p-8 rounded-[2.5rem] border border-muted relative overflow-hidden flex flex-col justify-between min-h-[280px] group">
        <div class="relative z-10">
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-500 text-[10px] font-bold uppercase tracking-wider mb-4">
                Nouveautés
            </div>
            <h3 class="text-2xl font-black text-body mb-3 tracking-tight">Explore l'écosystème</h3>
            <p class="text-muted text-sm max-w-sm leading-relaxed mb-8">
                Débloque de nouveaux thèmes dans la boutique ou recherche des verbes spécifiques pour approfondir tes
                connaissances.
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
        <div class="absolute -right-6 -bottom-6 text-9xl opacity-5 rotate-12 pointer-events-none group-hover:rotate-0 transition-transform duration-700">
            ✨
        </div>
    </div>

    <!-- Friends Section -->
    <div class="card-surface p-8 rounded-[2.5rem] border border-muted flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-body flex items-center gap-2 uppercase tracking-tighter">
                    🤝 Mes classmates
                </h3>
                <a href="{{ route('leaderboard', ['filter' => 'friendships']) }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">
                    Voir tout →
                </a>
            </div>

            @php $friends = auth()->user()->friends(10); @endphp
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
                    <a href="{{ route('leaderboard') }}"
                        class="px-4 py-2 border border-muted rounded-xl text-[10px] font-black text-muted hover:bg-muted/10 transition uppercase tracking-widest">Trouver
                        des amis</a>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-muted/50 flex items-center justify-between">
            <div class="text-[10px] text-muted font-bold uppercase tracking-widest">Public Profile</div>
            <a href="{{ route('profile.public', auth()->user()->username) }}"
                class="text-[10px] font-black text-primary hover:text-primary/80 transition-colors uppercase tracking-widest">
                VOIR MON PROFIL →
            </a>
        </div>
    </div>
</div>