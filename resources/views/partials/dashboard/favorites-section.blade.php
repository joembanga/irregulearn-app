<div class="card-surface p-6 md:p-8 rounded-2xl border border-muted relative overflow-hidden group/favs">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-5 relative z-10">
        <div class="flex items-center gap-3">
            <x-lucide-star class="size-9 md:size-10 fill-yellow-500 text-yellow-500" />
            <div>
                <h3 class="text-2xl font-bold text-body flex items-center gap-3 er">
                    {{ __("Mes derniers favoris") }}
                </h3>
                <p class="text-muted text-sm font-medium mt-1">{{ __("Les verbes à maîtriser en priorité.") }}</p>
            </div>
        </div>
        @if ($latestFavorites->count() > 0)
        <a href="{{ route('verbs.favorites') }}" wire:navigate
            class="px-6 py-3 text-center bg-surface border-2 border-primary/20 text-primary rounded-xl font-bold text-[10px] hover:bg-primary hover:text-surface transition-all uppercase  shadow-lg shadow-primary/5 active:scale-95">
            {{ __("Gérer ma collection") }} <x-lucide-move-right class="size-3 inline stroke-3" />
        </a>
        @endif
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-5 relative z-10">
        @forelse($latestFavorites as $fav)
        @php $stats = $fav->getPopularityStats(); @endphp

        <a href="{{ route('verbs.show', $fav->slug ?? '') }}" wire:navigate
            class="group relative p-4 bg-surface rounded-xl border-2 border-muted hover:border-primary hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(var(--primary-rgb),0.1)] transition-all duration-500 overflow-hidden flex flex-col justify-between min-h-40">
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="bg-primary/10 text-muted text-[8px] font-bold px-2 py-1 rounded-full uppercase tracking-widest">
                    {{ $stats['percentage'] }}%
                </span>
            </div>

            <div>
                <h4 class="text-xl font-bold text-body group-hover:text-primary transition-colors er uppercase leading-tight mb-4">
                    {{ $fav->infinitive }}
                </h4>

                <div class="flex flex-wrap gap-1.5 opacity-60 group-hover:opacity-100 transition-opacity">
                    <span class="text-[8px] font-bold text-body tracking-widest">{{ $fav->past_simple }}</span>
                    <span class="text-[8px] font-bold text-body tracking-widest">{{ $fav->past_participle }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-muted/30 flex items-center gap-3">
                @if ($stats['friends_count'] > 0)
                <div class="flex -space-x-2">
                    @foreach ($stats['friends']->take(2) as $friend)
                    <div title="{{ $friend->username }}"
                        class="relative size-6 rounded-full bg-app flex items-center justify-center text-muted font-bold overflow-hidden border-2 border-surface">
                        <x-user-avatar :user="$friend" />
                    </div>
                    @endforeach
                </div>
                <span class="text-[8px] font-bold text-muted uppercase tracking-widest">
                    {{ __("+ Amis", ["count" => $stats['friends_count']]) }}
                </span>
                @else
                <span class="text-[8px] font-bold text-muted uppercase tracking-widest italic group-hover:text-primary transition-colors">
                    {{ __("Priorisé par toi seul") }}
                </span>
                @endif
            </div>
        </a>
        @empty
        <div class="col-span-full text-center p-6 lg:py-12 bg-muted/5 rounded-xl border-2 border-dashed border-muted/30">
            <div class="text-4xl mb-4">
                <x-lucide-sparkles class="size-9 md:size-12 text-yellow-500 inline" />
            </div>
            <h4 class="text-sm font-bold text-body uppercase tracking-widest mb-2">{{ __("Aucun favori pour le moment") }}</h4>
            <p class="text-xs text-muted font-bold uppercase tracking-widest">
                {{ __("Ajoute des verbes à ta liste pour les retrouver ici.") }}
            </p>
        </div>
        @endforelse
    </div>
</div>