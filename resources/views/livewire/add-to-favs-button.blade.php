<div>
    @php
    $isFav = auth()->user()->favorites()->where('verb_id', $verb->id)->exists();
    @endphp

    <button wire:click="addTofavs({{ $verb->id }})" type="button"
        class="px-6 py-3 rounded-lg font-bold transition-colors {{ $isFav ? 'bg-red-100 text-red-600 border border-red-200' : 'bg-primary text-white' }}">
        {{ $isFav ? '❤️ Retirer des favoris' : '⭐ Ajouter aux favoris' }}
    </button>
</div>