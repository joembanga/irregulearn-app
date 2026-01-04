<div class="mt-6 p-6 card-surface rounded-3xl border border-muted text-center">
    <h4 class="font-bold text-warning mb-2 italic">Envoyer un cadeau XP 🎁</h4>

    @if (session()->has('success'))
    <p class="text-success text-xs font-bold mb-2">{{ session('success') }}</p>
    @endif
    @if (session()->has('error'))
    <p class="text-danger text-xs font-bold mb-2">{{ session('error') }}</p>
    @endif

    <div class="flex items-center gap-2">
        <input type="number" wire:model="amount"
            class="w-full border-muted rounded-xl focus:ring-primary focus:border-primary text-sm"
            placeholder="Montant...">
        <button wire:click="transfer"
            class="bg-warning text-surface px-4 py-2 rounded-xl font-bold hover:opacity-95 transition text-sm">
            Envoyer
        </button>
    </div>
    <p class="text-xs text-warning mt-2 italic">Ton solde : {{ auth()->user()->xp_balance }} XP</p>
</div>