<div class="card-surface p-8 md:p-10 rounded-[3rem] border border-muted relative overflow-hidden group/favs shadow-2xl shadow-muted/5">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6 relative z-10">
        <div>
            <h3 class="text-2xl font-black text-body flex items-center gap-3 uppercase tracking-tighter">
                <span class="text-primary text-3xl">⭐</span> Mes derniers favoris
            </h3>
            <p class="text-muted text-sm font-medium mt-1">Les verbes à maîtriser en priorité.</p>
        </div>
        @if ($latestFavorites->count() > 0)
        <a href="{{ route('verbs.favorites') }}" class="px-6 py-3 bg-surface border-2 border-primary/20 text-primary rounded-2xl font-black text-[10px] hover:bg-primary hover:text-surface transition-all uppercase tracking-[0.2em] shadow-lg shadow-primary/5 active:scale-95">
            Gérer ma collection →
        </a>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 relative z-10">
        @forelse($latestFavorites as $fav)
        @php $stats = $fav->getPopularityStats(); @endphp

        <a href="{{ route('verbs.show', $fav->slug ?? '') }}" class="group relative p-6 bg-surface rounded-[2rem] border-2 border-muted hover:border-primary hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(var(--primary-rgb),0.1)] transition-all duration-500 overflow-hidden flex flex-col justify-between min-h-[160px]">
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="bg-primary/10 text-primary text-[8px] font-black px-2 py-1 rounded-full uppercase tracking-widest">
                    {{ $stats['percentage'] }}%
                </span>
            </div>

            <div>
                <h4 class="text-xl font-black text-body group-hover:text-primary transition-colors tracking-tighter uppercase leading-tight mb-4">
                    {{ $fav->infinitive }}
                </h4>

                <div class="flex flex-wrap gap-1.5 opacity-60 group-hover:opacity-100 transition-opacity">
                    <span class="text-[8px] font-black text-muted uppercase tracking-widest">{{ $fav->past_simple }}</span>
                    <span class="text-[8px] font-black text-muted uppercase tracking-widest">{{ $fav->past_participle }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-muted/30 flex items-center gap-3">
                @if ($stats['friends_count'] > 0)
                <div class="flex -space-x-2">
                    @foreach ($stats['friends']->take(2) as $friend)
                    <div title="{{ $friend->username }}"
                        class="w-6 h-6 rounded-lg ring-2 ring-surface bg-indigo-500 flex items-center justify-center text-[8px] font-black text-white shadow-sm">
                        {{ substr($friend->username, 0, 1) }}
                    </div>
                    @endforeach
                </div>
                <span class="text-[8px] font-bold text-muted uppercase tracking-widest">
                    +{{ $stats['friends_count'] }} Amis
                </span>
                @else
                <span class="text-[8px] font-bold text-muted uppercase tracking-widest italic group-hover:text-primary transition-colors">
                    Priorisé par toi seul
                </span>
                @endif
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-12 bg-muted/5 rounded-[2.5rem] border-2 border-dashed border-muted/30">
            <div class="text-4xl mb-4">✨</div>
            <h4 class="text-sm font-black text-body uppercase tracking-widest mb-2">Aucun favori pour le moment</h4>
            <p class="text-[10px] text-muted font-bold uppercase tracking-widest">
                Ajoute des verbes à ta liste pour les retrouver ici.
            </p>
        </div>
        @endforelse
    </div>

    <!-- Decorative BG -->
    <div class="absolute -right-16 -bottom-16 text-[10rem] opacity-[0.03] font-black text-muted/100 rotate-12 pointer-events-none uppercase group-hover/favs:rotate-0 transition-transform duration-1000">
        STAR
    </div>
</div>