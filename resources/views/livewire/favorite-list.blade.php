<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($verbs as $verb)
    @php
    $stats = $verb->getPopularityStats();
    @endphp
    <div
        class="group relative card-surface rounded-3xl p-6 shadow-sm border border-muted hover:border-primary hover:shadow-xl transition-all duration-300">

        <div class="absolute top-4 right-4">
            <span
                class="text-[10px] font-black uppercase tracking-widest bg-primary-10 text-primary px-2 py-1 rounded-lg">
                {{ $stats['percentage'] }}% Popularité
            </span>
        </div>

        <div class="mb-4">
            <h3 class="text-2xl font-bold text-body group-hover:text-primary transition-colors">
                {{ $verb->infinitive }}
            </h3>
            <div class="flex gap-2 mt-1">
                <span class="text-xs font-mono text-muted bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded">
                    {{ Str::limit($verb->past_simple, 12) }}
                </span>
            </div>
        </div>

        <div class="pt-4 border-t border-muted/50">
            @if($stats['friends_count'] > 0)
            <div class="flex items-center gap-3">
                <div class="flex -space-x-2">
                    @foreach($stats['friends'] as $friend)
                    <div
                        class="w-7 h-7 rounded-full border-2 border-white dark:border-gray-900 bg-primary-10 flex items-center justify-center text-[10px] font-bold text-primary">
                        {{ substr($friend->username, 0, 1) }}
                    </div>
                    @endforeach
                </div>
                <span class="text-xs text-muted font-medium">
                    {{ $stats['friends_count'] }} ami(s) l'apprennent
                </span>
            </div>
            @else
            <span class="text-xs text-muted italic">Partage ce verbe avec tes amis !</span>
            @endif
        </div>

        <div wire:key="verb-{{ $verb->id }}" class="flex gap-2 mt-6">
            <a href="{{ route('verb', $verb->slug) }}"
                class="flex-1 py-2 bg-primary text-white text-center text-sm font-bold rounded-xl">
                Réviser
            </a>
        
            <button wire:click="removeFavorite({{ $verb->id }})"
                class="px-3 py-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors shadow-sm"
                title="Retirer des favoris">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center card-surface rounded-3xl border-2 border-dashed border-muted">
        <div class="text-6xl mb-4">⭐</div>
        <h3 class="text-xl font-bold text-body">Ta liste est vide</h3>
        <p class="text-muted mb-8 max-w-xs mx-auto">Enregistre les verbes qui te posent problème pour les
            retrouver ici facilement.</p>
        <a href="{{ route('verbslist') }}" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl">
            Parcourir les verbes
        </a>
    </div>

    @endforelse
</div>
