<x-app-layout>
    <div class="min-h-screen bg-app py-12 md:py-20 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="max-w-3xl mx-auto px-6 relative z-10">
            <div class="mb-12 text-center md:text-left flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-body tracking-tighter uppercase mb-4">
                        Notifications
                    </h1>
                    <p class="text-muted text-lg font-medium">Restez au courant de vos progrès et de vos amis.</p>
                </div>
                <div class="hidden md:block">
                    <span class="px-4 py-2 bg-surface border border-muted rounded-2xl text-[10px] font-black text-muted uppercase tracking-widest">
                        {{ $notifications->where('read_at', null)->count() }} Nouvelles
                    </span>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="group relative card-surface rounded-[2rem] border-2 transition-all duration-500 hover:shadow-2xl overflow-hidden {{ $notification->read_at ? 'border-muted/30 bg-surface/50 opacity-80' : 'border-primary/20 bg-primary/5 shadow-xl shadow-primary/5' }}">
                        <div class="p-6 md:p-8 flex items-start gap-6">
                            <!-- Icon -->
                            <div class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-3xl shadow-inner {{ $notification->read_at ? 'bg-muted/10 text-muted' : 'bg-primary/20 text-primary' }}">
                                {{ $notification->data['icon'] ?? '📢' }}
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-2">
                                    <h3 class="font-black text-body text-lg group-hover:text-primary transition-colors leading-tight">
                                        {{ $notification->data['message'] }}
                                    </h3>
                                    <span class="text-[10px] font-black text-muted uppercase tracking-widest shrink-0">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <div class="text-sm font-medium text-muted leading-relaxed mb-6">
                                    @if ($notification->type === 'App\Notifications\DailyVerbsNotification')
                                        Tu as <span class="text-primary font-bold">{{ $notification->data['verb_count'] ?? 0 }}</span> nouveaux verbes à découvrir aujourd'hui.
                                    @elseif ($notification->type === 'App\Notifications\NewFriendNotification')
                                        <span class="font-black text-body">{{ $notification->data['sender_username'] ?? __('Un utilisateur') }}</span> a commencé à te suivre !
                                    @elseif ($notification->type === 'App\Notifications\XpReceivedNotification')
                                        Ton nouveau solde est de <span class="font-black text-primary">{{ number_format($notification->data['new_balance'] ?? 0) }} XP</span>.
                                    @else
                                        {{ $notification->data['description'] ?? '' }}
                                    @endif
                                </div>

                                <a href="{{ url($notification->data['url'] ?? '/dashboard') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-body text-surface rounded-xl font-black text-[10px] uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-body/10 hover:bg-primary">
                                    Voir les détails
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        @if(!$notification->read_at)
                            <div class="absolute top-0 right-0 w-2 h-full bg-primary animate-pulse"></div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-24 bg-surface rounded-[4rem] border-4 border-dashed border-muted/30 relative overflow-hidden group">
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="text-[8rem] mb-8 group-hover:scale-110 transition-transform duration-500">
                                🧘
                            </div>
                            <h3 class="text-2xl font-black text-body tracking-tight uppercase mb-2">Tout est calme</h3>
                            <p class="text-muted max-w-xs mx-auto font-medium leading-relaxed">
                                Aucune nouvelle notification pour le moment. Repose-toi ou continue à apprendre !
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>