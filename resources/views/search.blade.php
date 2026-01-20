<x-app-layout>
    <div class="min-h-screen bg-app py-12 md:py-20 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10">
            <div class="mb-12 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-bold text-body tracking-tighter uppercase mb-4">
                    Exploration
                </h1>
                <p class="text-muted text-lg font-medium">Recherche un verbe complexe ou un camarade de classe.</p>
            </div>

            <livewire:search-page />
        </div>
    </div>
</x-app-layout>