<div>
    <button wire:click="toggleFollow"
        class="mt-6 px-6 py-2 rounded-2xl font-bold transition flex items-center gap-2 {{ $status === 'none' ? 'bg-primary text-surface hover:opacity-95' : 'bg-surface text-primary border border-primary' }}">
        @if($status === 'none')
        <span>➕</span> Ajouter ce joueur
        @else
        <span>👥</span> Ami·e (Retirer)
        @endif
    </button>
</div>