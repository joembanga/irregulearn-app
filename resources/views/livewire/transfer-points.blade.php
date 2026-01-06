<div class="mt-6 p-6 card-surface rounded-3xl border border-muted text-center">
    <h4 class="font-bold text-body mb-2">Envoyer des XP 🎁</h4>

    @if (session()->has('success'))
    <p class="text-success text-xs font-bold mb-2">{{ session('success') }}</p>
    @endif
    @if (session()->has('error'))
    <p class="text-danger text-xs font-bold mb-2">{{ session('error') }}</p>
    @endif

    <div class="flex items-center gap-2">
        <input type="number" wire:model.defer="userInput" class="w-full px-4 py-3 bg-surface border-muted focus:border-primary focus:ring-primary rounded-2xl shadow-sm text-body placeholder:text-muted/50 transition-all duration-200" placeholder="Montant...">
        <button wire:click="transfer" wire:keydown.enter="transfer"
            class="bg-primary text-surface px-4 py-3 rounded-xl font-bold hover:opacity-95 transition text-sm">
            Envoyer
        </button>
    </div>
    <p class="text-xs text-muted mt-2 italic">Ton solde : {{ auth()->user()->xp_balance }} XP</p>
</div>