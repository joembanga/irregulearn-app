<div>
    @forelse($verbs as $verb)
        @php
            $stats = $verb->getPopularityStats();
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
            <div class="group flex items-center relative card-surface rounded-2xl border border-muted transition-all duration-500 hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-2 overflow-hidden">

                <!-- Popularity Badge -->
                <div class="absolute top-2 right-2 z-10">
                    <div class="px-2 py-1 bg-primary/10 backdrop-blur-md rounded-xl border border-primary/20 shadow-sm flex items-center gap-2">
                        <span class="text-[10px] font-bold text-primary tracking-widest">{{ $stats['percentage'] }}%</span>
                    </div>
                </div>

                <div class="p-3 md:p-4 w-full">
                    <!-- Title & Forms -->
                    <div class="mb-6 pt-6">
                        <h3 class="text-xl lg:text-2xl font-bold text-body mb-2 group-hover:text-primary transition-colors">
                            {{ $verb->infinitive }}
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1.5 bg-primary/5 border border-primary/10 text-primary font-bold text-xs tracking-wider rounded-xl">
                                {{ $verb->past_simple }}
                            </span>
                            <span class="px-3 py-1.5 bg-success/5 border border-success/10 text-success font-bold text-xs tracking-wider rounded-xl">
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
                                            <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-muted font-black truncate">
                                            <x-user-avatar :user="$friend"/>
                                        </div>
                                    @endforeach
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold text-body uppercase tracking-widest">{{ $stats['friends_count'] }} Amis</div>
                                    <div class="text-[9px] font-bold text-muted uppercase">{{ __('L\'apprennent aussi') }}</div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-end gap-4">
                                <x-share-button :title=" __('To') . $verb->infinitive" :text="__('Le verbe To ') . $verb->slug . __(' sur Irregulearn')" :url="route('verbs.show', $verb->slug)" />

                                <button wire:click="removeFavorite({{ $verb->id }})" class="p-2 items-center justify-center bg-danger/5 text-danger border-2 border-danger/10 hover:bg-danger hover:text-surface hover:border-danger rounded-lg transition-all flex active:scale-90" title="Retirer des favoris">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <a href="{{ route('verbs.show', $verb->slug) }}" wire.navigate
                        class="flex-1 py-2 md:py-3 bg-primary text-surface text-center font-bold text-sm rounded-xl transition-all active:scale-95 flex items-center justify-center gap-2">
                        {{ __('Revoir') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="flex flex-col items-center justify-center py-6 text-center">
            <x-lucide-star class="size-16 fill-yellow-500 text-yellow-500 mb-6" />
            <h2 class="text-3xl font-bold text-body mb-3">{{ __('Ta liste est vide') }}</h2>
                <p class="text-muted mb-8 max-w-md text-lg">{{ __('Identifie les verbes qui te donnent du fil à retordre pour les réviser ici plus tard.') }}</p>
                <a href="{{ route('verbs.index', ['locale' => app()->getLocale()]) }}" wire:navigate
                    class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all active:scale-95 shadow-lg hover:shadow-xl">
                    {{ __('Parcourir les verbes') }}
                </a>
            </div>
        </div>
    @endforelse
</div>
