<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
    <!-- Daily Challenge Card (Prominent) -->
    <div class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-600 p-6 md:p-8 text-white shadow-xl">
        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div>
                    <h3 class="text-2xl md:text-3xl font-black mb-2">Défi Quotidien</h3>
                    <p class="text-indigo-100 mb-6 max-w-md text-sm md:text-base">
                        Tes verbes du jour t'attendent. Maîtrise-les pour garder ta série en vie !
                    </p>
                </div>
                <div class="hidden sm:block text-5xl bg-white/10 p-4 rounded-2xl backdrop-blur-sm self-start">
                    📅
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center mt-4">
                <a href="{{ route('learn.daily') }}" class="w-full sm:w-auto justify-center group flex items-center gap-3 px-8 py-4 bg-white text-indigo-600 rounded-2xl font-black text-lg transition hover:scale-105 active:scale-95 shadow-lg shadow-indigo-900/20">
                    <span>C'est parti !</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>

                <!-- Daily Verbs Preview -->
                @php $dailyVerbs = auth()->user()->dailyVerbs()->take(3)->get(); @endphp
                <div class="flex ml-0 sm:ml-4 -space-x-3 mt-2 sm:mt-0">
                    @foreach ($dailyVerbs as $dv)
                    @php $dvTranslation = $dv->translations()->where('lang', app()->getLocale())->first(); @endphp
                    <div class="h-10 px-4 bg-indigo-500/50 backdrop-blur-md rounded-full flex items-center justify-center border border-white/20 text-xs font-bold shadow-sm"
                        title="{{ app()->getLocale() !== "en" ? $dvTranslation->translation : '' }}">
                        {{ $dv->infinitive }}
                    </div>
                    @endforeach
                    @if (auth()->user()->dailyVerbs()->count() > 3)
                    <div class="h-10 w-10 bg-indigo-500/50 backdrop-blur-md rounded-full flex items-center justify-center border border-white/20 text-xs font-bold shadow-sm">
                        +{{ auth()->user()->dailyVerbs()->count() - 3 }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute top-10 right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl"></div>
    </div>

    <!-- Streak & Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4">
        <!-- Streak Card -->
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
                    <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 capitalize tracking-tight">
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
</div>