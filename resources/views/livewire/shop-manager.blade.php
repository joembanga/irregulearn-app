<div class="space-y-12">
    <!-- Messages -->
    @if (session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed bottom-6 right-6 z-50 bg-green-500/90 backdrop-blur-md text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce-in">
        <x-lucide-check-circle class="size-6" />
        <div class="font-bold">{{ session('success') }}</div>
    </div>
    @endif
    
    @if (session()->has('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed bottom-6 right-6 z-50 bg-red-500/90 backdrop-blur-md text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-shake">
        <x-lucide-alert-circle class="size-6" />
        <div class="font-bold">{{ session('error') }}</div>
    </div>
    @endif

    <!-- Hero Section / Balance -->
    <div class="relative overflow-hidden rounded-2xl bg-linear-to-br from-indigo-600 via-purple-600 to-pink-500 p-8 md:p-12 text-white shadow-2xl">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-black/10 blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="max-w-md">
                <h2 class="text-3xl font-bold mb-3 tracking-tight">Marché des Apprenants</h2>
                <p class="text-indigo-100/90 font-medium leading-relaxed">
                    Utilise tes points d'expérience pour débloquer des items exclusifs et personnaliser ton profil !
                </p>
            </div>
            <div class="bg-white/15 backdrop-blur-xl border border-white/20 rounded-2xl p-6 px-10 min-w-[220px] flex flex-col items-center shadow-lg">
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-80 mb-2">Ton Solde Actuel</span>
                <div class="text-5xl font-bold flex items-center gap-3 tabular-nums">
                    {{ number_format(auth()->user()->xp_balance) }}
                    <span class="text-sm font-bold bg-white/20 px-2 py-0.5 rounded-md">XP</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Power-Ups Section -->
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <div class="bg-blue-500/10 p-2.5 rounded-xl">
                <x-lucide-zap class="size-6 text-blue-500" />
            </div>
            <h3 class="text-2xl font-bold text-body tracking-tight">Boosters & Bonus</h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Streak Freeze -->
            <div class="group relative bg-surface border border-muted rounded-2xl p-8 transition-all duration-300 hover:shadow-xl hover:border-blue-500/30">
                <div class="flex flex-col items-center text-center h-full">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-blue-500/10 blur-2xl rounded-full scale-0 group-hover:scale-110 transition-transform"></div>
                        <div class="relative w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center text-4xl group-hover:-rotate-6 transition-transform">
                            ❄️
                        </div>
                    </div>
                    
                    <h4 class="text-xl font-bold text-body mb-2">Gel de Série</h4>
                    <p class="text-muted font-medium text-sm mb-8 leading-relaxed">
                        Protège ta série flamme 🔥 si tu manques une journée d'entraînement.
                    </p>

                    <div class="mt-auto w-full space-y-4">
                        <div class="flex justify-center items-center gap-2 text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-500/5 py-2 px-4 rounded-xl border border-blue-500/10">
                            En stock : {{ auth()->user()->streak_freezes }}
                        </div>
                        <button wire:click="buyFreeze"
                            class="w-full py-4 rounded-xl bg-linear-to-r from-blue-500 to-cyan-500 text-white font-bold shadow-lg shadow-blue-500/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span>2 000 XP</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Shop Section -->
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <div class="bg-purple-500/10 p-2.5 rounded-xl">
                <x-lucide-palette class="size-6 text-purple-500" />
            </div>
            <h3 class="text-2xl font-bold text-body tracking-tight">Style & Identité</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Mystery Box -->
            <div class="group relative bg-surface border-2 border-dashed border-purple-500/30 rounded-2xl p-8 transition-all duration-300 hover:shadow-xl hover:border-purple-500/50 bg-linear-to-br from-purple-500/5 to-transparent">
                <div class="flex flex-col items-center text-center h-full">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-purple-600 text-white text-[10px] font-bold px-4 py-1 rounded-full uppercase tracking-widest shadow-lg">
                        Meilleur Choix
                    </div>
                    
                    <div class="relative mb-6 mt-2">
                        <div class="absolute inset-0 bg-purple-500/20 blur-2xl rounded-full animate-pulse"></div>
                        <div class="relative w-20 h-20 bg-purple-50 rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 transition-all duration-500">
                            🎁
                        </div>
                    </div>

                    <h4 class="text-xl font-bold text-body mb-2">Boîte Mystère</h4>
                    <p class="text-muted font-medium text-sm mb-8 leading-relaxed">
                        Tente ta chance pour débloquer un accessoire premium aléatoire !
                    </p>

                    <button wire:click="buyRandomItem"
                        class="mt-auto w-full py-4 rounded-xl bg-linear-to-r from-purple-600 to-pink-600 text-white font-bold shadow-lg shadow-purple-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <span>800 XP</span>
                    </button>
                </div>
            </div>

            <!-- Sunglasses -->
            @php $hasGlasses = in_array('Sunglasses', auth()->user()->unlocked_items ?? []); @endphp
            <div class="group relative bg-surface border border-muted rounded-2xl p-8 transition-all duration-300 {{ $hasGlasses ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-xl hover:border-yellow-500/30' }}">
                <div class="flex flex-col items-center text-center h-full">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-yellow-500/10 blur-2xl rounded-full scale-0 group-hover:scale-110 transition-transform"></div>
                        <div class="relative w-20 h-20 bg-yellow-50 rounded-2xl flex items-center justify-center text-4xl group-hover:rotate-12 transition-transform">
                            😎
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-body mb-2">Lunettes Star</h4>
                    <p class="text-muted font-medium text-sm mb-8">Le look parfait pour briller.</p>

                    @if($hasGlasses)
                    <button disabled class="mt-auto w-full py-4 rounded-xl bg-app text-muted font-bold border border-muted cursor-not-allowed flex items-center justify-center gap-2">
                        <x-lucide-check class="size-4" />
                        {{ __('Possédé') }}
                    </button>
                    @else
                    <button wire:click="buyItem('Sunglasses', 1500)"
                        class="mt-auto w-full py-4 rounded-xl bg-linear-to-r from-yellow-500 to-orange-500 text-white font-bold shadow-lg shadow-yellow-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <span>1 500 XP</span>
                    </button>
                    @endif
                </div>
            </div>

            <!-- Skull Shirt -->
            @php $hasSkull = in_array('Skull', auth()->user()->unlocked_items ?? []); @endphp
            <div class="group relative bg-surface border border-muted rounded-2xl p-8 transition-all duration-300 {{ $hasSkull ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-xl hover:border-red-500/30' }}">
                <div class="flex flex-col items-center text-center h-full">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-red-500/10 blur-2xl rounded-full scale-0 group-hover:scale-110 transition-transform"></div>
                        <div class="relative w-20 h-20 bg-red-50 rounded-2xl flex items-center justify-center text-4xl group-hover:-rotate-12 transition-transform">
                            💀
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-body mb-2">Skull T-Shirt</h4>
                    <p class="text-muted font-medium text-sm mb-8">Un style rebelle pour l'apprentissage.</p>

                    @if($hasSkull)
                    <button disabled class="mt-auto w-full py-4 rounded-xl bg-app text-muted font-bold border border-muted cursor-not-allowed flex items-center justify-center gap-2">
                        <x-lucide-check class="size-4" />
                        {{ __('Possédé') }}
                    </button>
                    @else
                    <button wire:click="buyItem('Skull', 1200)"
                        class="mt-auto w-full py-4 rounded-xl bg-linear-to-r from-red-500 to-rose-500 text-white font-bold shadow-lg shadow-red-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <span>1 200 XP</span>
                    </button>
                    @endif
                </div>
            </div>

            <!-- Winter Hat -->
            @php $hasHat = in_array('WinterHat4', auth()->user()->unlocked_items ?? []); @endphp
            <div class="group relative bg-surface border border-muted rounded-2xl p-8 transition-all duration-300 {{ $hasHat ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-xl hover:border-cyan-500/30' }}">
                <div class="flex flex-col items-center text-center h-full">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-cyan-500/10 blur-2xl rounded-full scale-0 group-hover:scale-110 transition-transform"></div>
                        <div class="relative w-20 h-20 bg-cyan-50 rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                            🧢
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-body mb-2">Bonnet Hiver</h4>
                    <p class="text-muted font-medium text-sm mb-8">Garde tes idées au chaud.</p>

                    @if($hasHat)
                    <button disabled class="mt-auto w-full py-4 rounded-xl bg-app text-muted font-bold border border-muted cursor-not-allowed flex items-center justify-center gap-2">
                        <x-lucide-check class="size-4" />
                        {{ __('Possédé') }}
                    </button>
                    @else
                    <button wire:click="buyItem('WinterHat4', 1000)"
                        class="mt-auto w-full py-4 rounded-xl bg-linear-to-r from-cyan-400 to-blue-500 text-white font-bold shadow-lg shadow-cyan-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <span>1 000 XP</span>
                    </button>
                    @endif
                </div>
            </div>

            <!-- Diamond -->
            @php $hasDiamond = in_array('Diamond', auth()->user()->unlocked_items ?? []); @endphp
            <div class="group relative bg-surface border border-muted rounded-2xl p-8 transition-all duration-300 {{ $hasDiamond ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-xl hover:border-indigo-500/30' }}">
                <div class="flex flex-col items-center text-center h-full">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-indigo-500/10 blur-2xl rounded-full scale-0 group-hover:scale-110 transition-transform"></div>
                        <div class="relative w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                            💎
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-body mb-2">T-Shirt Diamond</h4>
                    <p class="text-muted font-medium text-sm mb-8">Brille de mille feux.</p>

                    @if($hasDiamond)
                    <button disabled class="mt-auto w-full py-4 rounded-xl bg-app text-muted font-bold border border-muted cursor-not-allowed flex items-center justify-center gap-2">
                        <x-lucide-check class="size-4" />
                        {{ __('Possédé') }}
                    </button>
                    @else
                    <button wire:click="buyItem('Diamond', 2500)"
                        class="mt-auto w-full py-4 rounded-xl bg-linear-to-r from-indigo-500 to-violet-500 text-white font-bold shadow-lg shadow-indigo-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <span>2 500 XP</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>