<x-app-layout>
    <div class="min-h-screen bg-app py-2 overflow-hidden">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 z-10">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
                <div class="md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-body tracking-tighter mb-4">
                        Bibliothèque <span class="text-primary">Globale</span>
                    </h1>
                    <p class="text-muted text-lg font-medium">Explorez l'intégralité des verbes irréguliers par niveau.</p>
                </div>

                <div class="flex flex-wrap justify-center gap-2 bg-surface p-2 rounded-2xl border border-muted shadow-xl shadow-muted/5">
                    @foreach(['beginner' => 'Débutant', 'intermediate' => 'Intermédiaire', 'expert' => 'Expert', 'all' => 'Tous'] as $lvl => $label)
                    <a href="{{ route('verbs.index', ['level' => $lvl]) }}" wire:navigate
                        class="px-6 py-3 rounded-xl text-xs font-bold tracking-widest transition-all duration-300 {{ $filter === $lvl ? 'bg-primary text-surface shadow-lg scale-105' : 'text-muted hover:text-primary' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Verb Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($verbs as $index => $verb)
                <div class="group flex items-center relative card-surface rounded-2xl border border-muted transition-all duration-500 hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-2 overflow-hidden">
                    <a href="{{ route('verbs.show', $verb->slug) }}" wire:navigate class="block w-full p-3 md:p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-bold text-muted/30 uppercase tracking-[0.2em]">
                                #{{ $verbs->firstItem() + $index }}
                            </span>
                            <div class="w-8 h-8 rounded-xl bg-app border border-muted flex items-center justify-center text-muted group-hover:text-primary transition-colors">
                                <x-heroicon-o-book-open class="size-4 stroke-current fill-none" />
                            </div>
                        </div>

                        <h3 class="text-xl lg:text-2xl font-bold text-body tracking-tighter uppercase mb-2 group-hover:text-primary transition-colors">
                            {{ $verb->infinitive }}
                        </h3>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between gap-1 p-2 md:p-3 bg-primary/5 rounded-xl border border-primary/10">
                                <span class="text-[9px] lg:text-[12px] text-left font-bold text-primary/60 uppercase tracking-widest"><abbr title="Past Simple">PS</abbr></span>
                                <span class="text-sm lg:text-[16px] font-bold text-right text-primary uppercase tracking-tight">{{ str_replace('/', ' / ', $verb->past_simple) }}</span>
                            </div>
                            <div class="flex items-center justify-between p-2 gap-2 md:p-3 bg-success/5 rounded-xl border border-success/10">
                                <span class="text-[9px] lg:text-[11px] font-bold text-left text-success/60 uppercase tracking-widest"><abbr title="Past Participle">PP</abbr></span>
                                <span class="text-sm lg:text-[16px] font-bold text-right text-success uppercase tracking-tight">{{ str_replace('/', ' / ', $verb->past_participle) }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-16">
                {{ $verbs->links() }}
            </div>

            <!-- Export Section -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 py-12 px-8 bg-primary rounded-xl shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 text-center md:text-left">
                    <h4 class="text-2xl font-bold text-body uppercase tracking-tight mb-2">Révision hors-ligne ?</h4>
                    <p class="text-indigo-100 font-medium">Téléchargez la liste complète au format PDF pour l'emporter partout.</p>
                </div>
                <a href="{{ route('verbs.export') }}" wire:navigate
                    class="relative z-10 flex items-center gap-3 bg-white text-primary px-10 py-5 rounded-xl font-bold text-sm uppercase tracking-[0.2em] shadow-xl transition-all hover:scale-110 active:scale-95">
                    <x-lucide-file-down class="size-5" />
                    Exporter en PDF
                </a>
                <!-- Decorative Decorative Decorative -->
                <div class="absolute -right-10 -bottom-10 text-[10rem] font-bold text-white/10 pointer-events-none uppercase rotate-12 group-hover:rotate-0 transition-transform duration-700">PDF</div>
            </div>
        </div>
    </div>
</x-app-layout>