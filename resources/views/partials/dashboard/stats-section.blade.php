<div class="grid grid-cols-3 lg:grid-cols-3 gap-6 lg:gap-8">    
    <!-- Streak & Stats Grid -->
    @php
        $timezone = auth()->user()->timezone ?? 'UTC';
        $localToday = now()->setTimezone($timezone)->toDateString();
        $lastActivity = auth()->user()->last_activity_local_date;
        $lastActivityDate = $lastActivity ? \Carbon\Carbon::parse($lastActivity)->toDateString() : null;
        $isDoneToday = $lastActivityDate === $localToday;
    @endphp
    <div class="group relative overflow-hidden rounded-3xl border border-muted bg-surface p-5 transition-all duration-300 hover:shadow-xl hover:shadow-orange-500/10">
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-muted mb-1">Ma Série</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-3xl font-black {{ $isDoneToday ? 'text-orange-500' : 'text-body' }}">
                        {{ auth()->user()->current_streak }}
                    </span>
                    <span class="text-xs font-bold text-muted">jours</span>
                </div>
            </div>
            <div class="relative">
                <span class="text-4xl transition-transform duration-500 group-hover:scale-125 block {{ $isDoneToday ? 'filter-none animate-pulse' : 'grayscale opacity-30 share-90' }}">
                    🔥
                </span>
            </div>
        </div>
        @if ($isDoneToday)
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-orange-500/10 rounded-full blur-2xl"></div>
        @endif
    </div>
    <!-- XP Card -->
    <div class="group relative overflow-hidden rounded-3xl border border-muted bg-surface p-5 transition-all duration-300 hover:shadow-xl hover:shadow-primary/10">
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-muted mb-1">XP Total</p>
                <p class="text-3xl font-black text-primary">{{ number_format($user->xp_total) }}</p>
            </div>
            <div class="h-12 w-12 rounded-2xl bg-primary/10 flex items-center justify-center text-2xl transition-transform duration-500 group-hover:rotate-12">
                ⚡
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-primary/10 rounded-full blur-2xl"></div>
    </div>
    <!-- Rank Card -->
    <div class="group relative overflow-hidden rounded-3xl border border-muted bg-surface p-5 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10">
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-muted mb-1">Rang actuel</p>
                <p class="text-2xl font-black text-primary capitalize tracking-tight">
                    {{ auth()->user()->level_name }}
                </p>
            </div>
            <div class="h-12 w-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-2xl transition-transform duration-500 group-hover:-translate-y-1">
                🎓
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-indigo-500/5 rounded-full blur-2xl"></div>
    </div>
</div>