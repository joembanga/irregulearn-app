<x-app-layout>
    <div class="min-h-screen bg-app py-12 md:py-20 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl translate-x-1/2"></div>
        <div class="absolute bottom-1/4 left-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl -translate-x-1/2"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-black text-body tracking-tighter uppercase mb-4">
                        Bibliothèque <span class="text-primary">Globale</span>
                    </h1>
                    <p class="text-muted text-lg font-medium">Explorez l'intégralité des verbes irréguliers par niveau.</p>
                </div>

                <div class="flex flex-wrap justify-center gap-2 bg-surface p-2 rounded-[2rem] border border-muted shadow-xl shadow-muted/5">
                    @foreach(['beginner' => 'Débutant', 'intermediate' => 'Intermédiaire', 'expert' => 'Expert', 'all' => 'Tous'] as $lvl => $label)
                        <a href="{{ route('verbs.index', ['level' => $lvl]) }}"
                            class="px-6 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all duration-300 {{ $filter === $lvl ? 'bg-primary text-surface shadow-lg shadow-primary/20 scale-105' : 'text-muted hover:text-primary' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Verb Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach ($verbs as $index => $verb)
                    <div class="group relative card-surface rounded-[2.5rem] border border-muted transition-all duration-500 hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-2 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-[10px] font-black text-muted/30 uppercase tracking-[0.2em]">
                                    #{{ $verbs->firstItem() + $index }}
                                </span>
                                <div class="w-8 h-8 rounded-xl bg-app border border-muted flex items-center justify-center text-muted group-hover:text-primary transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>

                            <h3 class="text-3xl font-black text-body tracking-tighter uppercase mb-6 group-hover:text-primary transition-colors">
                                {{ $verb->infinitive }}
                            </h3>

                            <div class="space-y-3 mb-8">
                                <div class="flex items-center justify-between p-3 bg-primary/5 rounded-2xl border border-primary/10">
                                    <span class="text-[9px] font-black text-primary/60 uppercase tracking-widest">Past Simple</span>
                                    <span class="text-sm font-black text-primary uppercase tracking-tight">{{ str_replace('/', ' / ', $verb->past_simple) }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-success/5 rounded-2xl border border-success/10">
                                    <span class="text-[9px] font-black text-success/60 uppercase tracking-widest">Past Participle</span>
                                    <span class="text-sm font-black text-success uppercase tracking-tight">{{ str_replace('/', ' / ', $verb->past_participle) }}</span>
                                </div>
                            </div>

                            <a href="{{ route('verbs.show', $verb->slug) }}" 
                                class="w-full py-4 flex items-center justify-center gap-2 bg-app border-2 border-muted/50 text-muted rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-body hover:text-surface hover:border-body">
                                Fiche complète
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-16">
                {{ $verbs->links() }}
            </div>

            <!-- Export Section -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 py-12 px-8 bg-primary rounded-[3rem] shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 text-center md:text-left">
                    <h4 class="text-2xl font-black text-body uppercase tracking-tight mb-2">Révision hors-ligne ?</h4>
                    <p class="text-indigo-100 font-medium">Téléchargez la liste complète au format PDF pour l'emporter partout.</p>
                </div>
                <a href="{{ route('verbs.export') }}"
                    class="relative z-10 flex items-center gap-3 bg-white text-primary px-10 py-5 rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] shadow-xl transition-all hover:scale-110 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exporter en PDF
                </a>
                <!-- Decorative Decorative Decorative -->
                <div class="absolute -right-10 -bottom-10 text-[10rem] font-black text-white/10 pointer-events-none uppercase rotate-12 group-hover:rotate-0 transition-transform duration-700">PDF</div>
            </div>
        </div>
    </div>
</x-app-layout>