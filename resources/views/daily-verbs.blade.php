<x-app-layout>
    <div class="py-12 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center gap-8">
        <div class="text-center mb-6">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-body">Tes verbes du jour</h2>
            <p class="mt-2 text-muted max-w-2xl mx-auto">Révise rapidement les verbes sélectionnés pour aujourd'hui.</p>
        </div>
        
        <livewire:daily-verbs :$dailyVerbs />
        
        @if($dailyVerbs->count() > 0)
            <a href="{{ route('learn.daily') }}"
                class="flex items-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                <span>🚀</span> Pratiquer pour mieux comprendre
            </a>
        @endif
    </div>
</x-app-layout>