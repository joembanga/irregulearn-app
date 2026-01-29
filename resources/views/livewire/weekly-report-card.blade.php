<div x-data="{ shareDialog: false }" 
     @openShare.window="shareDialog = true; 
         if (navigator.share) {
             navigator.share({
                 title: $event.detail[0].title,
                 text: $event.detail[0].text,
                 url: $event.detail[0].url
             }).then(() => shareDialog = false).catch(() => shareDialog = false);
         }">
    @if($report)
    <div class="card-surface rounded-3xl p-8 md:p-10 border border-surface shadow-xl hover:shadow-2xl transition-all duration-300">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-body mb-1">🏆 Weekly Mastery Report</h3>
                <p class="text-sm text-muted">
                    {{ $report->week_start_date->format('M d') }} - {{ $report->week_end_date->format('M d, Y') }}
                </p>
            </div>
            <div class="text-4xl">📊</div>
        </div>

        <!-- Main Stat - Verbs Mastered -->
        <div class="text-center mb-8 p-6 bg-linear-to-br from-primary/10 to-purple-500/10 rounded-2xl border border-primary/20">
            <div class="text-6xl mb-3">🔥</div>
            <div class="text-6xl md:text-7xl font-bold text-primary mb-2">
                {{ $report->verbs_mastered_count }}
            </div>
            <p class="text-lg font-semibold text-body uppercase tracking-wider">
                {{ $report->verbs_mastered_count === 1 ? 'New Verb Mastered' : 'New Verbs Mastered' }}
            </p>
        </div>

        <!-- Supporting Stats Grid -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <!-- Streak -->
            <div class="bg-app rounded-xl p-5 border border-surface text-center">
                <div class="text-3xl mb-2">🔥</div>
                <div class="text-3xl font-bold text-body mb-1">{{ $report->streak_at_end }}</div>
                <p class="text-xs text-muted uppercase tracking-wider">Days Streak</p>
                @if($report->streak_change > 0)
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">+{{ $report->streak_change }} this week</p>
                @endif
            </div>

            <!-- XP Earned -->
            <div class="bg-app rounded-xl p-5 border border-surface text-center">
                <div class="text-3xl mb-2">⚡</div>
                <div class="text-3xl font-bold text-body mb-1">{{ number_format($report->xp_earned) }}</div>
                <p class="text-xs text-muted uppercase tracking-wider">XP Earned</p>
            </div>

            <!-- Rank Change (if available) -->
            @if($report->rank_change !== null)
            <div class="col-span-2 bg-app rounded-xl p-5 border border-surface text-center">
                <div class="text-3xl mb-2">
                    @if($report->rank_change > 0)
                        📈
                    @elseif($report->rank_change < 0)
                        📉
                    @else
                        ➡️
                    @endif
                </div>
                <div class="text-2xl font-bold text-body mb-1">
                    @if($report->rank_change > 0)
                        <span class="text-green-600 dark:text-green-400">Rank Up +{{ $report->rank_change }}</span>
                    @elseif($report->rank_change < 0)
                        <span class="text-red-600 dark:text-red-400">Rank -{{ abs($report->rank_change) }}</span>
                    @else
                        <span class="text-muted">Rank Stable</span>
                    @endif
                </div>
                <p class="text-xs text-muted uppercase tracking-wider">Leaderboard Position</p>
            </div>
            @endif
        </div>

        <!-- Share Button -->
        <button 
            wire:click="share"
            class="w-full px-8 py-4 bg-linear-to-r from-primary to-purple-600 text-white font-bold rounded-xl hover:from-primary-dark hover:to-purple-700 transition-all active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center gap-3 group"
        >
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
            </svg>
            <span>Share My Weekly Results</span>
        </button>

        @if($report->shared_count > 0)
        <p class="text-center text-xs text-muted mt-3">
            Shared {{ $report->shared_count }} {{ $report->shared_count === 1 ? 'time' : 'times' }}
        </p>
        @endif
    </div>
    @else
    <!-- No Report Available -->
    <div class="card-surface rounded-3xl p-10 border border-surface text-center">
        <div class="text-6xl mb-4">📊</div>
        <h3 class="text-2xl font-bold text-body mb-2">No Weekly Report Yet</h3>
        <p class="text-muted">
            Keep learning! Your first weekly report will be generated on Monday.
        </p>
    </div>
    @endif
</div>
