<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-app text-body transition-colors duration-300 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-4xl md:text-5xl font-bold text-body mb-3">📊 Weekly Mastery Reports</h1>
                <p class="text-muted text-lg md:text-xl">Track your weekly progress and share your achievements</p>
            </div>

            @if($reports->count() > 0)
                <!-- Reports Grid -->
                <div class="grid gap-8">
                    @foreach($reports as $report)
                        <div class="card-surface rounded-2xl p-6 md:p-8 border border-surface shadow-lg hover:shadow-xl transition-all duration-300">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl md:text-2xl font-bold text-body mb-1">
                                        Week of {{ $report->week_start_date->format('M d') }} - {{ $report->week_end_date->format('M d, Y') }}
                                    </h3>
                                    <p class="text-sm text-muted">
                                        Generated {{ $report->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="text-4xl">🏆</div>
                            </div>

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <!-- Verbs Mastered -->
                                <div class="bg-app rounded-xl p-4 border border-surface text-center">
                                    <div class="text-3xl mb-2">🔥</div>
                                    <div class="text-2xl md:text-3xl font-bold text-primary mb-1">{{ $report->verbs_mastered_count }}</div>
                                    <p class="text-xs text-muted uppercase tracking-wider">Verbs Mastered</p>
                                </div>

                                <!-- Streak -->
                                <div class="bg-app rounded-xl p-4 border border-surface text-center">
                                    <div class="text-3xl mb-2">🔥</div>
                                    <div class="text-2xl md:text-3xl font-bold text-body mb-1">{{ $report->streak_at_end }}</div>
                                    <p class="text-xs text-muted uppercase tracking-wider">Days Streak</p>
                                </div>

                                <!-- XP Earned -->
                                <div class="bg-app rounded-xl p-4 border border-surface text-center">
                                    <div class="text-3xl mb-2">⚡</div>
                                    <div class="text-2xl md:text-3xl font-bold text-body mb-1">{{ number_format($report->xp_earned) }}</div>
                                    <p class="text-xs text-muted uppercase tracking-wider">XP Earned</p>
                                </div>

                                <!-- Rank Change -->
                                <div class="bg-app rounded-xl p-4 border border-surface text-center">
                                    <div class="text-3xl mb-2">
                                        @if($report->rank_change > 0)
                                            📈
                                        @elseif($report->rank_change < 0)
                                            📉
                                        @else
                                            ➡️
                                        @endif
                                    </div>
                                    <div class="text-2xl md:text-3xl font-bold mb-1
                                        @if($report->rank_change > 0) text-green-600 dark:text-green-400
                                        @elseif($report->rank_change < 0) text-red-600 dark:text-red-400
                                        @else text-muted
                                        @endif">
                                        @if($report->rank_change !== null)
                                            @if($report->rank_change > 0)
                                                +{{ $report->rank_change }}
                                            @elseif($report->rank_change < 0)
                                                {{ $report->rank_change }}
                                            @else
                                                --
                                            @endif
                                        @else
                                            --
                                        @endif
                                    </div>
                                    <p class="text-xs text-muted uppercase tracking-wider">Rank Change</p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('share.image', ['type' => 'weekly-report', 'identifier' => $report->id]) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary/10 border border-primary/20 text-primary rounded-lg font-semibold text-sm hover:bg-primary/20 transition active:scale-95 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    View Image
                                </a>
                                
                                @if($report->shared_count > 0)
                                <span class="inline-flex items-center gap-2 px-4 py-3 bg-surface rounded-lg text-muted text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Shared {{ $report->shared_count }} {{ $report->shared_count === 1 ? 'time' : 'times' }}
                                </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $reports->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="text-7xl mb-6">📊</div>
                    <h2 class="text-3xl font-bold text-body mb-3">No Weekly Reports Yet</h2>
                    <p class="text-muted mb-8 max-w-md text-lg">
                        Your first weekly report will be generated on Monday. Keep learning to build your stats!
                    </p>
                    <a href="{{ route('learn.index', ['locale' => app()->getLocale()]) }}" 
                       class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all active:scale-95 shadow-lg hover:shadow-xl">
                        Start Learning
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
