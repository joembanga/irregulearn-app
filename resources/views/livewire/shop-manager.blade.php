<div>
    @if (session()->has('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-2xl border border-green-200 font-bold text-center">
        {{ session('success') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-2xl border border-red-200 font-bold text-center">
        {{ session('error') }}
    </div>
    @endif

    <div class="rounded-3xl p-6 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(90deg,var(--color-primary), #a78bfa)">
        <div class="relative z-10">
            <h3 class="text-lg opacity-90 font-medium">Ton solde actuel</h3>
            <p class="text-5xl font-black">{{ number_format(auth()->user()->xp_balance) }} <span class="text-2xl text-white/80">XP</span></p>
        </div>
        <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 rotate-12">💎</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="card-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center text-4xl mb-4">❄️</div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Gel de Série</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Protège ta série si tu rates un jour d'entraînement.</p>
            <p class="text-xs font-bold text-primary mb-4 uppercase">Tu en possèdes : {{ auth()->user()->streak_freezes }}</p>
            <button wire:click="buyFreeze" class="mt-auto w-full bg-accent text-white py-4 rounded-2xl font-black hover:opacity-95 transition flex justify-between px-6"> <span>ACHETER</span> <span>2,000 XP</span></button>
        </div>
    </div>
</div>