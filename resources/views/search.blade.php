<x-app-layout>
    <div class="min-h-screen bg-app py-2 md:py-4 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 relative z-10">
            <div class="mb-12 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-body mb-4">
                    {{ __('Exploration') }}
                </h1>
                <p class="text-muted text-lg font-medium">{{ __('Recherche un verbe complexe ou un camarade de classe.') }}</p>
            </div>

            <livewire:search-page />
        </div>
    </div>
</x-app-layout>