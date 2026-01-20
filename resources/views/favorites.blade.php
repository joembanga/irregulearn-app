<x-app-layout>
    <div class="min-h-screen bg-app py-12 md:py-20 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 -translate-x-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl translate-y-1/2 translate-x-1/2"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-bold text-body tracking-tighter uppercase mb-4">
                        Ma <span class="text-primary">Sélection</span>
                    </h1>
                    <p class="text-muted text-lg font-medium">Tes <span class="font-bold text-primary">{{ $verbs->count() }}</span> verbes prioritaires pour tes prochaines sessions.</p>
                </div>

                @if($verbs->count() > 0)
                <a href="{{ route('learn.session', ['mode' => 'favorites']) }}" wire:navigate
                    class="group flex items-center justify-center gap-4 px-10 py-5 bg-primary text-surface font-bold text-sm uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-primary/20 transition-all duration-300 hover:scale-105 active:scale-95">
                    <span class="text-xl">🚀</span> 
                    Lancer la Révision
                </a>
                @endif
            </div>
            
            <livewire:favorite-list :$verbs />
        </div>
    </div>
</x-app-layout>