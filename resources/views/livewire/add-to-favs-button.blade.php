<div>
    <button wire:click="addTofavs({{ $verbId }})" type="button"
        class="inline-flex items-center gap-2 p-2 border border-muted text-body rounded-xl font-bold text-sm transition active:scale-95 bg-surface text-body">
        @if ($isFav)
            <x-lucide-star class="size-5 fill-yellow-500 stroke-yellow-500" />
        @else
            <x-lucide-star class="size-5" />
        @endif
    </button>
</div>