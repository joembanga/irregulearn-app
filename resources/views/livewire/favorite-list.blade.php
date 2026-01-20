<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($verbs as $verb)
        @php
            $stats = $verb->getPopularityStats();
        @endphp
        <div wire:key="fav-verb-{{ $verb->id }}" class="group relative card-surface rounded-[2.5rem] border-2 border-muted transition-all duration-500 hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-2 overflow-hidden">
            
            <!-- Popularity Badge -->
            <div class="absolute top-6 right-6 z-10">
                <div class="px-4 py-2 bg-primary/10 backdrop-blur-md rounded-2xl border border-primary/20 shadow-sm flex items-center gap-2">
                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest">{{ $stats['percentage'] }}% Popularité</span>
                </div>
            </div>

            <div class="p-8">
                <!-- Title & Forms -->
                <div class="mb-8 pt-4">
                    <h3 class="text-3xl font-bold text-body tracking-tighter uppercase mb-4 transition-colors group-hover:text-primary">
                        {{ $verb->infinitive }}
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 bg-primary/5 border border-primary/10 text-primary font-bold text-[10px] uppercase tracking-wider rounded-xl">
                            {{ $verb->past_simple }}
                        </span>
                        <span class="px-3 py-1.5 bg-success/5 border border-success/10 text-success font-bold text-[10px] uppercase tracking-wider rounded-xl">
                            {{ $verb->past_participle }}
                        </span>
                    </div>
                </div>

                <!-- Social Stats -->
                <div class="py-6 border-t border-muted/50">
                    @if ($stats['friends_count'] > 0)
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-3">
                                @foreach ($stats['friends'] as $friend)
                                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black truncate">
                                        <x-user-avatar :user="$friend"/>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-body uppercase tracking-widest">{{ $stats['friends_count'] }} Amis</div>
                                <div class="text-[9px] font-bold text-muted uppercase">L'apprennent aussi</div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-[10px] font-bold text-muted uppercase tracking-widest italic">Partage avec des amis</span>
                            <button x-data="{ copied: false }" @click="navigator.clipboard.writeText('{{ route('verbs.show', $verb->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-muted/5 border-2 border-transparent hover:border-primary/20 text-body rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all active:scale-95 group/btn">
                                <span x-show="!copied" class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-muted group-hover/btn:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Partager
                                </span>
                                <span x-show="copied" x-cloak class="text-success">Copié !</span>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex gap-3 mt-4">
                    <a href="{{ route('verbs.show', $verb->slug) }}" wire.navigate
                        class="flex-1 py-5 bg-body text-surface text-center font-bold text-[10px] uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-body/10 transition-all hover:bg-primary hover:shadow-primary/20 active:scale-95 flex items-center justify-center gap-2">
                        Réviser
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <button wire:click="removeFavorite({{ $verb->id }})"
                        class="w-14 items-center justify-center bg-danger/5 text-danger border-2 border-danger/10 hover:bg-danger hover:text-surface hover:border-danger rounded-2xl transition-all flex active:scale-90"
                        title="Retirer des favoris">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-24 text-center bg-surface rounded-[4rem] border-4 border-dashed border-muted/30 relative overflow-hidden group">
            <div class="relative z-10 flex flex-col items-center">
                <div class="text-[8rem] mb-8 transition-transform duration-500 group-hover:scale-110">⭐</div>
                <h3 class="text-3xl font-bold text-body tracking-tight uppercase mb-4">Ta liste est vide</h3>
                <p class="text-muted mb-12 max-w-xs mx-auto font-medium leading-relaxed">
                    Identifie les verbes qui te donnent du fil à retordre pour les réviser ici plus tard.
                </p>
                <a href="{{ route('verbs.index') }}" class="px-12 py-5 bg-body text-surface font-bold text-sm uppercase tracking-[0.2em] rounded-2xl shadow-2xl transition-all hover:bg-primary active:scale-95" wire.navigate>
                    Chercher des verbes
                </a>
            </div>
        </div>
    @endforelse
</div>
