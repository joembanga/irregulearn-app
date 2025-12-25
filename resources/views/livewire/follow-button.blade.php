<div>
    <button wire:click="toggleFollow"
        class="mt-6 px-8 py-3 rounded-2xl font-bold transition flex items-center gap-2 {{ $status === 'none' ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-gray-200 text-gray-700' }}">
        @if($status === 'none')
        <span>➕</span> Ajouter ce Joueur
        @else
        <span>✅</span> Amis (Retirer)
        @endif
    </button>
</div>