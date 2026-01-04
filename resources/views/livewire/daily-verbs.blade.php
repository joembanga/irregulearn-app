<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($dailyVerbs as $verb)
        <div class="group relative card-surface rounded-3xl p-6 shadow-sm border border-muted hover:border-primary hover:shadow-xl transition-all duration-300">

            <div class="mb-4">
                <h3 class="text-2xl font-bold text-body group-hover:text-primary transition-colors">
                    {{ $verb->infinitive }}
                </h3>
                <div class="flex gap-2 mt-1">
                    <span class="text-xs font-mono text-muted bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded">
                        {{ Str::title($verb->past_simple) }}
                    </span>
                </div>
            </div>

            <div class="pt-4 border-t border-muted/50">
                <span class="text-xs text-muted italic">Partage ce verbe avec tes amis !</span>
            </div>

            <div wire:key="verb-{{ $verb->id }}" class="flex gap-2 mt-6">
                <a href="{{ route('verbs.show', $verb->slug) }}"
                    class="flex-1 py-2 bg-primary text-white text-center text-sm font-bold rounded-xl">
                    Réviser
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 text-center card-surface rounded-3xl border-2 border-dashed border-muted">
            <h3 class="text-xl font-bold text-body">Rien de nouveau à découvrir</h3>
            <p class="text-muted mb-8 max-w-xs mx-auto">
                Tu as appris tout tes verbes, reste branché pour les prochaines mises à jour
            </p>
            <a href="{{ route('verbs.index') }}" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl">
                Parcourir les verbes
            </a>
        </div>
    @endforelse
</div>