<div class="space-y-12">
    <!-- Messages -->
    @if (session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed bottom-6 right-6 z-50 bg-green-500/90 backdrop-blur-md text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce-in">
        <span class="text-2xl">🎉</span>
        <div class="font-bold">{{ session('success') }}</div>
    </div>
    @endif
    @if (session()->has('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed bottom-6 right-6 z-50 bg-red-500/90 backdrop-blur-md text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-shake">
        <span class="text-2xl">🚫</span>
        <div class="font-bold">{{ session('error') }}</div>
    </div>
    @endif

    <!-- Hero Section / Balance -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-[#6366f1] via-[#8b5cf6] to-[#d946ef] p-10 text-white shadow-2xl">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-black/10 blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div>
                <h2 class="text-2xl font-bold opacity-90 mb-1">Boutique Premium</h2>
                <p class="text-indigo-100/80 text-sm max-w-sm">Utilise tes XP durement gagnés pour débloquer des bonus et du style !</p>
            </div>
            <div class="bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl p-4 px-8 min-w-[200px] flex flex-col items-center">
                <span class="text-xs font-bold uppercase tracking-widest opacity-80 mb-1">Ton Solde</span>
                <div class="text-4xl font-black flex items-center gap-2">
                    {{ number_format(auth()->user()->xp_balance) }} <span class="text-xl">XP</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Power-Ups Section -->
    <div>
        <h3 class="text-xl font-black text-body mb-6 flex items-center gap-2">
            <span class="bg-blue-100 text-blue-600 p-2 rounded-xl">⚡</span> Power-Ups
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Streak Freeze -->
            <div class="relative group bg-surface border border-muted rounded-3xl p-1 overflow-hidden hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300">
                <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition"></div>
                <div class="relative bg-surface rounded-[1.3rem] p-6 h-full flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center text-5xl mb-4 group-hover:scale-110 transition-transform">❄️</div>
                    <h4 class="text-xl font-bold text-body mb-2">Gel de Série</h4>
                    <p class="text-muted text-sm mb-6 leading-relaxed">Protège ta série flamme 🔥 si tu manques une journée d'entraînement.</p>
                    
                    <div class="mt-auto w-full">
                        <div class="flex justify-center items-center gap-2 mb-4 text-xs font-bold text-blue-600 uppercase tracking-widest bg-blue-50 py-1.5 px-4 rounded-full">
                            En stock: {{ auth()->user()->streak_freezes }}
                        </div>
                        <button wire:click="buyFreeze" 
                            class="w-full py-3.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-black shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span>2 000 XP</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Shop Section -->
    <div>
        <h3 class="text-xl font-black text-body mb-6 flex items-center gap-2">
            <span class="bg-purple-100 text-purple-600 p-2 rounded-xl">🎭</span> Avatar & Style
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Mystery Box -->
            <div class="relative group bg-surface border border-muted rounded-3xl p-1 overflow-hidden hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300">
                <div class="absolute inset-0 bg-purple-500/5 group-hover:bg-purple-500/10 transition"></div>
                <div class="relative bg-surface rounded-[1.3rem] p-6 h-full flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center text-5xl mb-4 group-hover:scale-110 transition-transform animate-pulse-slow">🎁</div>
                    <div class="absolute top-4 right-4 bg-purple-100 text-purple-700 text-[10px] font-black px-2 py-1 rounded-md uppercase">Best Value</div>
                    
                    <h4 class="text-xl font-bold text-body mb-2">Boîte Mystère</h4>
                    <p class="text-muted text-sm mb-6 leading-relaxed">Tente ta chance pour débloquer un accessoire premium aléatoire !</p>
                    
                    <button wire:click="buyRandomItem" 
                        class="mt-auto w-full py-3.5 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 text-white font-black shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                        <span>800 XP</span>
                    </button>
                </div>
            </div>

            <!-- Sunglasses -->
            @php $hasGlasses = in_array('Sunglasses', auth()->user()->unlocked_items ?? []); @endphp
            <div class="relative group bg-surface border border-muted rounded-3xl p-1 overflow-hidden hover:shadow-xl transition-all duration-300 {{ $hasGlasses ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-yellow-500/10' }}">
                <div class="relative bg-surface rounded-[1.3rem] p-6 h-full flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-yellow-50 rounded-full flex items-center justify-center text-5xl mb-4 group-hover:rotate-12 transition-transform">😎</div>
                    <h4 class="text-xl font-bold text-body mb-2">Lunettes Star</h4>
                    <p class="text-muted text-sm mb-6">Le look parfait pour briller.</p>
                    
                    @if($hasGlasses)
                        <button disabled class="mt-auto w-full py-3.5 rounded-xl bg-gray-100 text-gray-400 font-bold border border-gray-200 cursor-not-allowed flex items-center justify-center gap-2">
                            ✅ Possédé
                        </button>
                    @else
                        <button wire:click="buyItem('Sunglasses', 1500)" 
                            class="mt-auto w-full py-3.5 rounded-xl bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-black shadow-lg shadow-yellow-500/25 hover:shadow-yellow-500/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span>1 500 XP</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Skull Shirt -->
            @php $hasSkull = in_array('Skull', auth()->user()->unlocked_items ?? []); @endphp
            <div class="relative group bg-surface border border-muted rounded-3xl p-1 overflow-hidden hover:shadow-xl transition-all duration-300 {{ $hasSkull ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-red-500/10' }}">
                <div class="relative bg-surface rounded-[1.3rem] p-6 h-full flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center text-5xl mb-4 group-hover:-rotate-12 transition-transform">💀</div>
                    <h4 class="text-xl font-bold text-body mb-2">Skull T-Shirt</h4>
                    <p class="text-muted text-sm mb-6">Un style rebelle pour l'apprentissage.</p>
                    
                    @if($hasSkull)
                        <button disabled class="mt-auto w-full py-3.5 rounded-xl bg-gray-100 text-gray-400 font-bold border border-gray-200 cursor-not-allowed flex items-center justify-center gap-2">
                            ✅ Possédé
                        </button>
                    @else
                        <button wire:click="buyItem('Skull', 1200)" 
                            class="mt-auto w-full py-3.5 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 text-white font-black shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span>1 200 XP</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Winter Hat -->
            @php $hasHat = in_array('WinterHat4', auth()->user()->unlocked_items ?? []); @endphp
            <div class="relative group bg-surface border border-muted rounded-3xl p-1 overflow-hidden hover:shadow-xl transition-all duration-300 {{ $hasHat ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-cyan-500/10' }}">
                <div class="relative bg-surface rounded-[1.3rem] p-6 h-full flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-cyan-50 rounded-full flex items-center justify-center text-5xl mb-4 group-hover:scale-110 transition-transform">🧢</div>
                    <h4 class="text-xl font-bold text-body mb-2">Bonnet Hiver</h4>
                    <p class="text-muted text-sm mb-6">Garde tes idées au chaud.</p>
                    
                    @if($hasHat)
                        <button disabled class="mt-auto w-full py-3.5 rounded-xl bg-gray-100 text-gray-400 font-bold border border-gray-200 cursor-not-allowed flex items-center justify-center gap-2">
                            ✅ Possédé
                        </button>
                    @else
                        <button wire:click="buyItem('WinterHat4', 1000)" 
                            class="mt-auto w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-black shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span>1 000 XP</span>
                        </button>
                    @endif
                </div>
            </div>

             <!-- Diamond -->
            @php $hasDiamond = in_array('Diamond', auth()->user()->unlocked_items ?? []); @endphp
            <div class="relative group bg-surface border border-muted rounded-3xl p-1 overflow-hidden hover:shadow-xl transition-all duration-300 {{ $hasDiamond ? 'opacity-60 grayscale-[0.5]' : 'hover:shadow-indigo-500/10' }}">
                <div class="relative bg-surface rounded-[1.3rem] p-6 h-full flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center text-5xl mb-4 group-hover:scale-110 transition-transform">💎</div>
                    <h4 class="text-xl font-bold text-body mb-2">T-Shirt Diamond</h4>
                    <p class="text-muted text-sm mb-6">Brille de mille feux.</p>
                    
                    @if($hasDiamond)
                        <button disabled class="mt-auto w-full py-3.5 rounded-xl bg-gray-100 text-gray-400 font-bold border border-gray-200 cursor-not-allowed flex items-center justify-center gap-2">
                            ✅ Possédé
                        </button>
                    @else
                        <button wire:click="buyItem('Diamond', 2500)" 
                            class="mt-auto w-full py-3.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-500 text-white font-black shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span>2 500 XP</span>
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>