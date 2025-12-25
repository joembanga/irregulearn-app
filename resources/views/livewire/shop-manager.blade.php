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

    <div
        class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 mb-8 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-lg opacity-80 font-medium">Ton solde actuel</h3>
            <p class="text-5xl font-black">{{ number_format(auth()->user()->xp_balance) }} <span
                    class="text-2xl text-indigo-200">XP</span></p>
        </div>
        <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 rotate-12">💎</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-4xl mb-4">❄️</div>
            <h3 class="text-xl font-bold text-gray-800">Gel de Série</h3>
            <p class="text-gray-500 text-sm mb-2">Protège ta série si tu rates un jour d'entraînement.</p>
            <p class="text-xs font-bold text-blue-600 mb-4 uppercase">Tu en possèdes :
                {{ auth()->user()->streak_freezes }}</p>
            <button wire:click="buyFreeze"
                class="mt-auto w-full bg-blue-600 text-white py-4 rounded-2xl font-black hover:bg-blue-700 transition flex justify-between px-6">
                <span>ACHETER</span>
                <span>2,000 XP</span>
            </button>
        </div>
    </div>
</div>