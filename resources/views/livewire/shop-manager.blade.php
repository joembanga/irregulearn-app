<div>
    @if (session()->has('success'))
    <div class="mb-4 p-4 bg-success-10 text-success rounded-2xl border border-success font-bold text-center">
        {{ session('success') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="mb-4 p-4 bg-danger-10 text-danger rounded-2xl border border-danger font-bold text-center">
        {{ session('error') }}
    </div>
    @endif

    <div class="rounded-3xl p-6 mb-8 text-body relative overflow-hidden bg-gradient-to-br from-primary to-#a78bfa">
        <div class="relative z-10">
            <h3 class="text-lg opacity-90 font-medium">Ton solde actuel</h3>
            <p class="text-5xl font-black">{{ number_format(auth()->user()->xp_balance) }} <span
                    class="text-2xl text-surface/80">XP</span></p>
        </div>
        <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 rotate-12">💎</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="card-surface p-6 rounded-2xl shadow-sm border border-muted flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center text-4xl mb-4">❄️</div>
            <h3 class="text-xl font-bold text-body">Gel de Série</h3>
            <p class="text-muted text-sm mb-2">Protège ta série si tu rates un jour d'entraînement.</p>
            <p class="text-xs font-bold text-primary mb-4 uppercase">Tu en possèdes :
                {{ auth()->user()->streak_freezes }}</p>
            <button wire:click="buyFreeze"
                class="mt-auto w-full bg-accent text-surface py-4 rounded-2xl font-black hover:opacity-95 transition flex justify-between px-6">
                <span>ACHETER</span> <span>2,000 XP</span></button>
        </div>
    </div>
</div>