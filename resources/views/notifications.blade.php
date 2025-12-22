<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🔔 Tes Notifications
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                <div class="p-6">
                    @forelse($notifications as $notification)
                    <div
                        class="flex items-start gap-4 p-4 mb-4 rounded-2xl transition {{ $notification->read_at ? 'bg-gray-50 opacity-60' : 'bg-indigo-50 border-l-4 border-indigo-500' }}">
                        <div class="text-3xl">
                            {{ $notification->data['icon'] ?? '📢' }}
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-gray-900">
                                    {{ $notification->data['message'] }}
                                </h3>
                                <span class="text-xs text-gray-400 font-medium">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mt-1">
                                Tu as {{ $notification->data['verb_count'] ?? 0 }} nouveaux verbes à découvrir
                                aujourd'hui.
                            </p>

                            <div class="mt-3">
                                <a href="{{ url($notification->data['url'] ?? '/dashboard') }}"
                                    class="text-sm font-bold text-indigo-600 hover:underline">
                                    Voir maintenant →
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <span class="text-5xl">🧘</span>
                        <p class="mt-4 text-gray-500 font-medium">Rien de nouveau pour l'instant. Reviens plus tard !
                        </p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>