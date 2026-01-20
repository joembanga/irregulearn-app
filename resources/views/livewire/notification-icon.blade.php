<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open; if(open) $wire.markAllAsRead()" 
            class="relative p-2 rounded-xl text-muted hover:bg-surface hover:text-primary transition-all duration-200"
            aria-label="{{ __('Notifications') }}">
            <x-lucide-bell class="size-6 transition-all group-hover:fill-current"/>
        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-2 right-2 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-danger opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-danger border-2 border-app"></span>
            </span>
        @endif
    </button>

    <!-- Popover -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute top-full right-0 mt-3 w-80 bg-surface border border-muted rounded-2xl shadow-2xl overflow-hidden z-70"
         x-cloak>
        
        <div class="px-5 py-4 border-b border-muted flex justify-between items-center bg-surface">
            <h3 class="font-bold text-body text-sm uppercase tracking-widest">{{ __('Notifications') }}</h3>
            @if(count($notifications) > 0)
                <button wire:click="clearAll" 
                        class="text-[10px] font-bold text-muted hover:text-danger uppercase tracking-wider transition-colors">
                    {{ __('Tout vider') }}
                </button>
            @endif
        </div>

        <div class="max-h-[350px] overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-5 py-4 border-b border-muted/50 hover:bg-muted/5 transition-colors last:border-0 relative group">
                    <div class="flex gap-4">
                        <div class="h-10 w-10 rounded-full bg-primary/10 shrink-0 flex items-center justify-center text-lg">
                            @if(isset($notification->data['type']) && $notification->data['type'] == 'achievement') 🏆 @else ✨ @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-body leading-snug">
                                {{ $notification->data['message'] ?? __('Notification') }}
                            </p>
                            <p class="text-[10px] text-muted mt-1 font-medium italic">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if(!$notification->read_at)
                            <div class="h-2 w-2 rounded-full bg-primary mt-2"></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 px-6 text-center">
                    <div class="text-4xl mb-3 opacity-20">🍃</div>
                    <p class="text-sm text-muted font-medium">{{ __('Aucune notification pour le moment.') }}</p>
                </div>
            @endforelse
        </div>

        @if(count($notifications) > 0)
            <div class="bg-muted/5 p-4 text-center border-t border-muted">
                <p class="text-[10px] text-muted font-bold uppercase tracking-widest">{{ __('Restez à l\'écoute pour de nouveaux défis !') }}</p>
            </div>
        @endif
    </div>
</div>