<x-app-layout>

    <div class="py-12">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🔔 Tes Notifications
        </h2>
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div
                class="card-surface overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-700 shadow-lg">
                <div class="p-6">
                    @forelse($notifications as $notification)
                    <div
                        class="flex items-start gap-4 p-4 mb-4 rounded-2xl transition {{ $notification->read_at ? 'bg-surface opacity-80' : 'bg-primary-10 border-l-4 border-primary' }}">
                        <div class="text-3xl">
                            {{ $notification->data['icon'] ?? '📢' }}
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-body">{{ $notification->data['message'] }}</h3>
                                <span
                                    class="text-xs text-muted font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            @if ($notification->type === 'App\Notifications\DailyVerbsNotification')
                            <p class="text-sm text-muted mt-1">Tu as {{ $notification->data['verb_count'] ?? 0 }}
                                nouveaux verbes à découvrir aujourd'hui.</p>
                            <div class="mt-3"><a href="{{ url($notification->data['url'] ?? '/dashboard') }}"
                                    class="text-sm font-bold text-primary hover:underline">Voir maintenant →</a></div>
                            @elseif ($notification->type === 'App\Notifications\NewFriendNotification')
                            <p class="text-sm text-muted mt-1"><span
                                    class="font-semibold">{{ $notification->data['sender_username'] ?? __('Un utilisateur') }}</span>
                                a commencé à te suivre !</p>
                            <div class="mt-3"><a href="{{ url($notification->data['url'] ?? '/dashboard') }}"
                                    class="text-sm font-bold text-primary hover:underline">Voir son profil →</a></div>
                            @elseif ($notification->type === 'App\Notifications\XpReceivedNotification')
                            <p class="text-sm text-muted mt-1">Tu as maintenant <span
                                    class="font-semibold">{{ $notification->data['new_balance'] ?? '' }}</span> XP
                                disponibles</p>
                            <div class="mt-3"><a href="{{ url($notification->data['url'] ?? '/shop') }}"
                                    class="text-sm font-bold text-primary hover:underline">Aller à la boutique →</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <span class="text-5xl">🧘</span>
                        <p class="mt-4 text-gray-700 dark:text-gray-200 font-medium">Rien de nouveau pour l'instant.
                            Reviens plus tard !</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>