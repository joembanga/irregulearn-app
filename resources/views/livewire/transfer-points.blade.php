<div class="mt-6 p-6 bg-amber-50 rounded-3xl border border-amber-100 text-center">
    <h4 class="font-bold text-amber-900 mb-2 italic">Envoyer un cadeau XP 🎁</h4>

    @if (session()->has('success'))
    <p class="text-green-600 text-xs font-bold mb-2">{{ session('success') }}</p>
    @endif
    @if (session()->has('error'))
    <p class="text-red-600 text-xs font-bold mb-2">{{ session('error') }}</p>
    @endif

    <div class="flex items-center gap-2">
        <input type="number" wire:model="amount"
            class="w-full border-amber-200 rounded-xl focus:ring-amber-500 focus:border-amber-500 text-sm"
            placeholder="Montant...">
        <button wire:click="transfer"
            class="bg-amber-500 text-white px-4 py-2 rounded-xl font-bold hover:bg-amber-600 transition text-sm">
            Envoyer
        </button>
    </div>
    <p class="text-[10px] text-amber-700 mt-2 italic">Ton solde : {{ auth()->user()->xp_balance }} XP</p>
</div>