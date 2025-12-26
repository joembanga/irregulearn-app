<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <div class="card-surface rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Entraînement Libre</h2>
                        <div class="flex items-center gap-2">
                            <button class="px-3 py-2 bg-accent text-white rounded-lg">Mix aléatoire</button>
                            <button class="px-3 py-2 bg-primary text-white rounded-lg">Commencer</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <livewire:quiz-engine />
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="card-surface rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">🏆 Champions de la semaine</h3>
                    <div class="space-y-3">
                        @foreach($topThree as $index => $topUser)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-primary font-bold">#{{ $index + 1 }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $topUser->username }}</span>
                            </div>
                            <span
                                class="text-sm bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200">{{ number_format($topUser->xp_total) }}
                                XP</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('leaderboard') }}"
                        class="block text-center mt-6 text-sm text-accent hover:underline">Voir le classement
                        complet</a>
                </div>
            </aside>

        </div>
    </div>
</x-app-layout>