<div class="relative flex-1 max-w-xl mx-2 md:mx-8"
     x-data="{ 
         isOpen: false
     }"
     @click.away="isOpen = false">
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
            <x-lucide-search class="size-4 text-muted" />
        </div>
        <input 
            wire:model.live.debounce.200ms="query"
            @focus="isOpen = true"
            @input="isOpen = true"
            type="search" 
            placeholder="{{ __('Recherche de verbes ou d\'utilisateurs...') }}"
            class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-surface border-transparent text-body text-sm focus:ring-2 focus:ring-primary/50 focus:bg-surface transition-all placeholder:text-muted/60" 
        />
        
        <div wire:loading wire:target="query" class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <x-lucide-loader-2 class="animate-spin size-4 text-primary" />
        </div>
    </div>

    <!-- Search Results Dropdown -->
    <div x-show="isOpen && ($wire.results.length > 0 || $wire.query.length >= 2)"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute top-full left-0 right-0 mt-2 bg-surface border border-muted rounded-2xl shadow-2xl overflow-hidden z-60"
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
                        <x-lucide-move-right class="size-4 text-muted group-hover:text-primary transition-colors" />
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
