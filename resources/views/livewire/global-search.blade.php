<div class="relative flex-1 max-w-xl mx-2 md:mx-8"
     x-data="{ 
         isOpen: false
     }"
     @click.away="isOpen = false">
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
            <svg class="h-4 w-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input 
            wire:model.live.debounce.300ms="query"
            @focus="isOpen = true"
            @input="isOpen = true"
            type="search" 
            placeholder="{{ __('Recherche de verbes ou d\'utilisateurs...') }}"
            class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-surface border-transparent text-body text-sm focus:ring-2 focus:ring-primary/50 focus:bg-surface transition-all placeholder:text-muted/60" 
        />
        
        <div wire:loading wire:target="query" class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <svg class="animate-spin h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <!-- Search Results Dropdown -->
    <div 
        x-show="isOpen && ($wire.results.length > 0 || $wire.query.length >= 2)"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute top-full left-0 right-0 mt-2 bg-surface border border-muted rounded-2xl shadow-2xl overflow-hidden z-[60]"
        x-cloak
    >
        @if(count($results) > 0)
            <div class="py-2">
                @foreach($results as $result)
                    <a href="{{ $result['url'] }}" 
                       wire:navigate
                       @click="isOpen = false"
                       class="flex items-center gap-4 px-4 py-3 hover:bg-muted/30 transition-colors group">
                        <span class="text-xl group-hover:scale-110 transition-transform">{{ $result['icon'] }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-body truncate">{{ $result['title'] }}</p>
                            <p class="text-xs text-muted truncate">{{ $result['subtitle'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-muted group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endforeach
            </div>
            <div class="bg-muted/10 px-4 py-2 border-t border-muted">
                <a href="{{ route('search', ['q' => $query]) }}" wire:navigate class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">
                    {{ __('Voir tous les résultats pour') }} "{{ $query }}"
                </a>
            </div>
        @elseif(strlen($query) >= 2)
            <div class="p-8 text-center">
                <p class="text-muted text-sm">{{ __('Aucun résultat trouvé.') }}</p>
            </div>
        @endif
    </div>
</div>
