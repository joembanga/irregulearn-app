<div class="grid grid-cols-3 gap-3 md:gap-6 lg:gap-8">    
    <!-- Streak & Stats Grid -->
    @php
        $timezone = auth()->user()->timezone ?? 'UTC';
        $localToday = now()->setTimezone($timezone)->toDateString();
        $lastActivity = auth()->user()->last_activity_local_date;
        $lastActivityDate = $lastActivity ? \Carbon\Carbon::parse($lastActivity)->toDateString() : null;
        $isDoneToday = $lastActivityDate === $localToday;
    @endphp
    <!-- Streak Card -->
    <div class="group relative overflow-hidden rounded-xl border border-muted bg-surface p-3 md:p-5 transition-all duration-300 hover:shadow-2xl hover:shadow-orange-500/10 flex flex-col justify-between">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-2">
            <div>
                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-wider md: text-muted mb-1 truncate">{{ __('Ma Série') }}</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-xl md:text-3xl font-bold {{ $isDoneToday ? 'text-orange-500' : 'text-body' }}">
                        {{ auth()->user()->current_streak }}
                    </span>
                    <span class="text-[10px] md:text-xs font-bold text-muted">{{ __('J') }}</span>
                </div>
            </div>
            <div class="relative self-end md:self-auto -mt-6 md:mt-0">
                <span class="text-2xl md:text-4xl transition-transform duration-500 group-hover:-translate-y-1 block {{ $isDoneToday ? 'filter-none animate-pulse' : 'grayscale opacity-30 share-90' }}">
                    <x-flame-gradient />
                    <x-lucide-flame class="size-7 md:size-9 stroke-orange-600 fill-[url(#flame-grad)]"  stroke-width="1.5" />
                </span>
            </div>
        </div>
        @if ($isDoneToday)
        <div class="absolute -right-4 -bottom-4 w-12 h-12 md:w-20 md:h-20 bg-orange-500/10 rounded-full blur-xl md:blur-2xl"></div>
        @endif
    </div>

    <!-- XP Card -->
    <div class="group relative overflow-hidden rounded-xl border border-muted bg-surface p-3 md:p-5 transition-all duration-300 hover:shadow-2xl hover:shadow-yellow-500/10 flex flex-col justify-between">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-2">
            <div>
                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-wider md: text-muted mb-1 truncate">{{ __('XP Total') }}</p>
                <p class="text-lg md:text-3xl font-bold text-yellow-500 truncate">{{ number_format($user->xp_total) }}</p>
            </div>
            <div class="h-8 w-8 md:h-12 md:w-12 flex items-center justify-center text-2xl md:text-2xl transition-transform duration-500 group-hover:-translate-y-1 self-end md:self-auto -mt-6 md:mt-0">
                <x-lucide-zap class="size-7 md:size-9 stroke-yellow-500 fill-yellow-300" />
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-12 h-12 md:w-20 md:h-20 bg-yellow-500/10 rounded-full blur-xl md:blur-2xl"></div>
    </div>

    <!-- Rank Card -->
    <div class="group relative overflow-hidden rounded-xl border border-muted bg-surface p-3 md:p-5 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/10 flex flex-col justify-between">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-2">
            <div>
                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-wider md: text-muted mb-1 truncate">{{ __('Rang') }}</p>
                <p class="text-lg md:text-3xl font-bold text-purple-800 capitalize truncate leading-tight">
                    {{ auth()->user()->level_name }}
                </p>
            </div>
            <div class="h-8 w-8 md:h-12 md:w-12 flex items-center justify-center text-2xl md:text-4xl transition-transform duration-500 group-hover:-translate-y-1 self-end md:self-auto -mt-6 md:mt-0">
                <x-lucide-graduation-cap class="size-7 md:size-9 stroke-purple-900 fill-purple-600 mt-5" />
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-12 h-12 md:w-20 md:h-20 bg-purple-500/10 rounded-full blur-xl md:blur-2xl"></div>
    </div>
</div>