<x-app-layout>
    <div class="py-12 bg-app min-h-screen">
        <div class="max-w-5xl mx-auto px-6">

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                <div>
                    <h1 class="text-4xl font-black text-body tracking-tight">Tes verbes <span
                            class="text-primary">préférés</span></h1>
                    <p class="text-muted mt-2">Tu as sélectionné <span
                            class="font-bold text-body">{{ $verbs->count() }}</span> verbes à réviser en priorité.</p>
                </div>

                @if($verbs->count() > 0)
                <a href="{{ route('learn.favorites') }}"
                    class="flex items-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 transition-all duration-300 hover:scale-105 active:scale-95">
                    <span>🚀</span> Pratiquer tes favoris
                </a>
                @endif
            </div>
            
            <livewire:favorite-list :$verbs />
        </div>
    </div>
</x-app-layout>