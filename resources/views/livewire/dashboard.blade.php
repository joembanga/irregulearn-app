<div class="py-12 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-6">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white">Tes verbes du jour</h2>
        <p class="mt-2 text-gray-700 dark:text-gray-400 max-w-2xl mx-auto">Révise rapidement les verbes sélectionnés
            pour aujourd'hui.</p>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($dailyVerbs as $verb)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $verb->infinitive }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $verb->translation }}</div>
                </div>
                <div>
                    <a href="{{ route('learn.category', $verb->categories->first()?->slug ?? '') }}"
                        class="text-sm text-primary hover:underline">Apprendre</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center text-sm text-gray-600 dark:text-gray-400">Aucun verbe du jour pour l'instant.
        </div>
        @endforelse
    </div>
</div>