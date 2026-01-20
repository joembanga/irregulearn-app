<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($dailyVerbs as $verb)
        <div class="group relative card-surface rounded-[2.5rem] p-8 border border-muted hover:border-primary/50 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 flex flex-col justify-between min-h-[320px]">
            
            <div class="absolute top-6 right-6 opacity-10 group-hover:opacity-100 transition-opacity">
                <div class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 bg-primary/10 text-primary rounded-lg">
                    {{ $verb->level ?? 'Mastery' }}
                </div>
            </div>

            <div>
                <h3 class="text-3xl font-bold text-body group-hover:text-primary transition-colors mb-2 uppercase tracking-tight">
                    {{ $verb->infinitive }}
                </h3>
                <p class="text-xs font-bold text-muted uppercase tracking-widest mb-6">Irregular Verb</p>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-app rounded-2xl border border-muted/50 group-hover:bg-white/50 transition-colors">
                        <span class="text-[10px] font-bold text-muted uppercase">Past Simple</span>
                        <span class="text-sm font-bold text-body">{{ Str::title($verb->past_simple) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-app rounded-2xl border border-muted/50 group-hover:bg-white/50 transition-colors">
                        <span class="text-[10px] font-bold text-muted uppercase">Past Participle</span>
                        <span class="text-sm font-bold text-body">{{ Str::title($verb->past_participle ?? $verb->past_simple) }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <a href="{{ route('verbs.show', $verb->slug) }}" wire.navigate
                    class="flex-1 py-4 bg-primary text-surface text-center text-xs font-bold rounded-2xl uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                    Détails du verbe
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-32 text-center card-surface rounded-[3rem] border-2 border-dashed border-muted flex flex-col items-center justify-center">
            <div class="text-6xl mb-6 opacity-20">✨</div>
            <h3 class="text-2xl font-bold text-body uppercase tracking-tight">Magnifique !</h3>
            <p class="text-muted mb-10 max-w-sm mx-auto font-medium">
                Tu as terminé tous tes verbes prévus. Reviens demain pour de nouveaux défis.
            </p>
            <a href="{{ route('verbs.index') }}" wire.navigate class="px-10 py-4 bg-body text-surface font-bold rounded-2xl uppercase text-xs tracking-widest hover:scale-105 transition-all active:scale-95 shadow-xl">
                Parcourir la bibliothèque
            </a>
        </div>
    @endforelse
</div>