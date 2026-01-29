<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <!-- Promoted Daily Target -->
    <div class="lg:col-span-2 relative overflow-hidden rounded-2xl bg-linear-to-br from-purple-500 to-indigo-600 p-6 text-white shadow-xl flex items-center justify-center sm:justify-between md:justify-center lg:justify-between">
        <div class="relative z-10 flex flex-col sm:flex-row md:flex-col lg:flex-row items-center justify-center gap-5 md:gap-8">
            <div class="h-24 w-24 bg-white/10 p-4 rounded-2xl backdrop-blur-sm flex items-center justify-center text-4xl shadow-xl shadow-primary/30 group-hover:rotate-6 transition-transform">
                @if ($user->hadLearnedTodaysVerbs())
                    <x-lucide-calendar-check class="size-full" />
                @else
                    <x-lucide-calendar-fold class="size-full" />
                @endif
            </div>
            <div class="flex-1 text-center sm:text-left md:text-center lg:text-left">
                <h3 class="text-2xl font-bold mb-2">{{ __("Objectif du jour") }} 
                    @if ($user->hadLearnedTodaysVerbs())
                        <x-lucide-check class="size-7 stroke-3 inline"/>
                    @endif
                </h3>
                <p class="text-indigo-100 mb-6 max-w-md text-sm sm:text-base">
                    @if ($user->hadLearnedTodaysVerbs())
                    {{ __("Bravo ! Tu as pratiqué les ") }} <strong>{{ $user->daily_target }}</strong> {{ __("verbes prévus pour toi aujourd'hui.") }}<br>
                    {{ __("Revois ta liste pour ne pas oublier ce que tu as appris") }}
                    @else
                    {{ __("Tes") }} <strong>{{ $user->daily_target }}</strong> {{ __("verbes à maîtriser aujourd'hui sont pret !") }}<br>
                    {{ __("Ta progression quotidienne est le moteur de ta réussite.") }}
                    @endif
                </p>
                <div class="w-full sm:w-auto flex flex-nowrap group justify-center sm:justify-start md:justify-center lg:justify-start gap-4">
                    <a href="{{ route('verbs.today') }}" wire:navigate
                        class="flex justify-center items-center p-3 px-5 gap-2 bg-white text-indigo-600 rounded-xl font-bold text-sm hover:scale-105 transition shadow-lg active:scale-95">
                        <span><x-lucide-list-check class="size-6"/></span>
                        {{ __("VOIR MA LISTE DU JOUR") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 text-8xl opacity-[0.05] font-bold pointer-events-none uppercase">
            {{ __('Daily') }}
        </div>
    </div>

    <!-- Shrinked Mastery Card -->
    <div class="card-surface p-8 rounded-xl border border-muted flex flex-col items-center justify-center text-center relative overflow-hidden">
        <div class="relative h-24 w-24 mb-4">
            <svg class="h-full w-full" viewBox="0 0 36 36">
                <path class="text-muted" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="text-primary" stroke-width="4" stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-xl font-bold text-body leading-none">{{ round($progressPercent) }}%</span>
            </div>
        </div>
        <h4 class="text-sm font-bold text-body uppercase tracking-widest mb-1">{{ __("Maîtrise Globale") }}</h4>
        <p class="text-xs font-bold text-muted uppercase">
            <span class="text-body">{{ $learnedVerbsCount }}</span> {{ __("VERBES APPRIS") }}
        </p>
        <a href="{{ route('learn.index') }}" wire:navigate class="mt-4 text-[10px] font-bold text-primary hover:underline uppercase tracking-widest">
            {{ __("PLUS") }} <x-lucide-move-right class="size-2 inline stroke-3" />
        </a>
    </div>
</div>