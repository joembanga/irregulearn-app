<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Promoted Daily Target -->
    <div class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary to-violet-600 p-6 md:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div
                class="h-24 w-24 bg-white/10 p-4 rounded-2xl backdrop-blur-sm text-surface flex items-center justify-center text-4xl shadow-xl shadow-primary/30 group-hover:rotate-6 transition-transform">
                🎯
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-2xl md:text-3xl font-black mb-2">Défi Quotidien</h3>
                <p class="text-indigo-100 mb-6 max-w-md text-sm md:text-base">
                    Tes verbes du jour t'attendent. Maîtrise-les pour garder ta série en vie !
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <a href="{{ route('verbs.today') }}" wire:navigate
                        class="flex justify-center items-center px-8 py-3 bg-primary text-body rounded-2xl font-black text-sm hover:scale-105 transition shadow-lg active:scale-95">
                        📋 VOIR MA LISTE DU JOUR
                    </a>
                    <a href="{{ route('learn.session', ['mode' => 'daily']) }}" wire:navigate
                        class="w-full sm:w-auto justify-center group flex items-center gap-3 px-8 py-3 bg-white text-primary rounded-2xl font-black text-lg transition hover:scale-105 active:scale-95 shadow-lg shadow-indigo-900/20">
                        <span>C'est parti !</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 text-8xl opacity-[0.03] font-black pointer-events-none uppercase">
            Daily
        </div>
    </div>

    <!-- Shrinked Mastery Card -->
    <div class="card-surface p-8 rounded-[2.5rem] border border-muted flex flex-col items-center justify-center text-center relative overflow-hidden">
        <div class="relative h-24 w-24 mb-4">
            <svg class="h-full w-full" viewBox="0 0 36 36">
                <path class="text-muted/20" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="text-primary" stroke-width="4" stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-xl font-black text-body leading-none">{{ round($progressPercent) }}%</span>
            </div>
        </div>
        <h4 class="text-sm font-black text-body uppercase tracking-widest mb-1">Maîtrise Globale</h4>
        <p class="text-[10px] font-bold text-muted uppercase">
            <span class="text-body">{{ $learnedVerbsCount }}</span> VERBES APPRIS
        </p>
        <a href="{{ route('learn.index') }}" wire:navigate class="mt-4 text-[10px] font-black text-primary hover:underline uppercase tracking-widest">Détails →</a>
    </div>
</div>