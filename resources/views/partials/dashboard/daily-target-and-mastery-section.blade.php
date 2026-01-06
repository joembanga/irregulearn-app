<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Promoted Daily Target -->
    <div class="lg:col-span-2 card-surface p-8 rounded-[2.5rem] border-2 border-primary/20 bg-primary/5 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="h-24 w-24 rounded-3xl bg-primary text-surface flex items-center justify-center text-4xl shadow-xl shadow-primary/30 group-hover:rotate-6 transition-transform">
                🎯
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-2xl font-black text-body mb-2 uppercase tracking-tight">Objectif du jour</h3>
                <p class="text-muted text-sm mb-6 leading-relaxed">
                    Tu as choisi de maîtriser <span class="text-primary font-bold">{{ $user->daily_target }} verbes</span> aujourd'hui. <br class="hidden md:block"> 
                    Ta progression quotidienne est le moteur de ta réussite.
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <a href="{{ route('verbs.today') }}" class="px-8 py-3 bg-primary text-surface rounded-2xl font-black text-sm hover:scale-105 transition shadow-lg active:scale-95">
                        📋 VOIR MA LISTE DU JOUR
                    </a>
                    <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-surface border border-muted text-body rounded-2xl font-bold text-xs hover:bg-muted/10 transition">
                        Modifier l'objectif
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
                <path class="text-primary" stroke-width="4" stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-xl font-black text-body leading-none">{{ round($progressPercent) }}%</span>
            </div>
        </div>
        <h4 class="text-sm font-black text-body uppercase tracking-widest mb-1">Maîtrise Globale</h4>
        <p class="text-[10px] font-bold text-muted uppercase">
            <span class="text-body">{{ $learnedVerbsCount }}</span> VERBES APPRIS
        </p>
        <a href="{{ route('learn.index') }}" class="mt-4 text-[10px] font-black text-primary hover:underline uppercase tracking-widest">Détails →</a>
    </div>
</div>