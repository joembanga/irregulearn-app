<div class="relative inline-block">
    <button class="p-2 rounded-full bg-surface border border-muted shadow-sm">
        <a href="{{ route('notifications') }}">
            <span class="text-xl">🔔</span>
        </a>
    </button>
    {{-- Show badge when there are unread notifications --}}
    @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
    <span
        class="absolute -top-1 -right-1 inline-flex items-center justify-center h-5 w-5 rounded-full bg-danger text-surface text-xs">{{ auth()->user()->unreadNotifications->count() }}</span>
    @endif
</div>