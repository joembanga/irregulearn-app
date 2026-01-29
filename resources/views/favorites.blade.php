@section('title', __('My favorites'))
@section('description', __('...'))
@section('keywords', '...')
<x-app-layout>
    <div class="py-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 md:mb-10 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-body">
                    {{ __("Ma Sélection") }}
                </h1>
                <p class="text-muted font-medium mt-2 text-lg">
                    {{ __("Tes") }} <span class="font-bold text-primary">{{ $verbs->count() }}</span> {{ __("verbes prioritaires pour tes prochaines sessions.") }}
                </p>
            </div>

            @if($verbs->count() > 0)
            <a href="{{ route('learn.session', ['mode' => 'favorites']) }}" wire:navigate
                class="group flex items-center justify-center gap-2 px-4 md:px-6 py-3 bg-primary text-surface font-bold text-lg rounded-xl transition-all duration-300 hover:scale-105 active:scale-95">
                <span class="text-xl">🚀</span> 
                {{ __("Lancer la Révision") }}
            </a>
            @endif
        </div>
    
        <livewire:favorite-list :$verbs />
    </div>
</x-app-layout>