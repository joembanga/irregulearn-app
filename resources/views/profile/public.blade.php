<x-app-layout>
    @php
    $isFriend = DB::table('friendships')
    ->where(function($q) use ($user) {
    $q->where('sender_id', auth()->id())->where('recipient_id', $user->id);
    })
    ->where('status', 'accepted')
    ->exists();
    @endphp

    @if($isFriend)
    <livewire:transfer-points :receiver="$user" />
    @endif
    <div class="py-12 bg-app text-body">
        <div class="max-w-4xl mx-auto px-6">

            <div
                class="bg-surface rounded-3xl p-8 shadow-sm border border-muted flex flex-col items-center text-center">
                <div
                    class="w-24 h-24 bg-gradient-to-br from-primary to-purple-600 rounded-full flex items-center justify-center text-4xl text-white font-bold mb-4 shadow-lg">
                    {{ substr($user->username, 0, 1) }}
                </div>
                <h1 class="text-3xl font-black text-body">{{ $user->username }}</h1>
                <p class="text-muted">Membre depuis {{ $user->created_at->format('M Y') }}</p>

                @if(auth()->id() !== $user->id)
                <livewire:follow-button :user="$user" />
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-surface p-6 rounded-3xl shadow-sm text-center">
                    <p class="text-sm text-muted uppercase font-bold">Streak 🔥</p>
                    <p class="text-2xl font-black">{{ $user->current_streak }} jours</p>
                </div>
                <div class="bg-surface p-6 rounded-3xl shadow-sm text-center">
                    <p class="text-sm text-muted uppercase font-bold">XP obtenus cette semaine ✨</p>
                    <p class="text-2xl font-black">{{ number_format($user->xp_weekly) }}</p>
                </div>
                <div class="bg-surface p-6 rounded-3xl shadow-sm text-center">
                    <p class="text-sm text-muted uppercase font-bold">Verbes vus 📖</p>
                    <p class="text-2xl font-black">{{ $user->verb()->wherePivot('mastered', true)->count() }}</p>
                </div>
            </div>

            <div class="mt-8 bg-surface p-8 rounded-3xl shadow-sm border border-muted">
                <h3 class="font-bold text-body mb-6">Badges débloqués</h3>
                <div class="flex flex-wrap gap-4">
                    @forelse($user->badges as $badge)
                    <div class="group relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-primary/20 to-purple-600/20 rounded-2xl flex items-center justify-center text-2xl shadow-sm hover:scale-110 transition-transform">
                            {{ $badge->icon }}</div>
                        <span
                            class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-[10px] font-bold opacity-0 group-hover:opacity-100 transition whitespace-nowrap">{{ $badge->name }}</span>
                    </div>
                    @empty
                    <p class="text-muted text-sm">Aucun badge débloqué pour le moment.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>