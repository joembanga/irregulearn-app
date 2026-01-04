<div>
    <button wire:click="toggleFollow"
        class="mt-6 px-6 py-2 rounded-2xl font-bold transition flex items-center gap-2 {{ $status === 'none' ? 'bg-primary text-surface hover:opacity-95' : 'bg-surface dark:bg-gray-700 text-muted dark:text-muted' }}">
        @if($status === 'none')
        <span>➕</span> Ajouter ce joueur
        @else
        <span>✅</span> Ami·e (Retirer)
        @endif
    </button>
</div>