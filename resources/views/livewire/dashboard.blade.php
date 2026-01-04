<div class="py-12 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-6">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-body">Tes verbes du jour</h2>
        <p class="mt-2 text-muted max-w-2xl mx-auto">Révise rapidement les verbes sélectionnés pour aujourd'hui.</p>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($dailyVerbs as $verb)
        <div class="card-surface rounded-xl p-4 shadow-sm border border-muted">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-semibold text-body">{{ $verb->infinitive }}</div>
                    <div class="text-sm text-muted">{{ $verb->translation }}</div>
                </div>
                <div>
                    <a href="{{ route('learn.category', $verb->categories->first()?->slug ?? '') }}"
                        class="text-sm text-primary hover:underline">Apprendre</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center text-sm text-muted">Aucun verbe du jour pour l'instant.
        </div>
        @endforelse
    </div>
</div>