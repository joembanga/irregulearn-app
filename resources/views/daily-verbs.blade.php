@section('title', __('Verbes du jour'))
@section('description', __('Les ') . $user->daily_target . __(" verbes qui ont été sélectionnés pour toi aujourd'hui"))
@section('keywords', '...')
@section('og_title', __('Mes verbes du jour'))
@section('og_description', __('Ma sélection de verbes irréguliers pour aujourd\'hui sur IrreguLearn !'))
@section('og_image', route('share.image', ['type' => 'daily', 'identifier' => $user->username ]))
<x-app-layout>
    <div class="py-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8 md:mb-10 flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-body">{{ __('Tes verbes du jour') }}</h1>
                <p class="text-muted font-medium mt-2 text-lg">
                    {{ __('Voici la sélection personnalisée pour aujourd\'hui.') }} <br> {{ __('Prends quelques minutes pour les mémoriser avant de passer au test.') }}
                </p>
            </div>
            <div class="flex items-center justify-end gap-3 pt-8">
                @if($dailyVerbs->count() > 0)
                    <a href="{{ route('learn.session', ['mode' => 'daily']) }}"
                        class="group flex items-center gap-4 px-6 py-2 bg-primary text-surface font-bold shadow-sm rounded-xl hover:scale-105 transition-all text-lg active:scale-95">
                        <span>{{ __('Pratiquer maintenent') }}</span>
                    </a>
                @endif
                <x-share-button :title="__('Mes verbes du jour')" :text="__('Ma sélection de verbes irréguliers pour aujourd\'hui sur IrreguLearn !')" :url="route('verbs.today')" />
            </div>
        </div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($dailyVerbs as $verb)
    <div
        class="group relative card-surface rounded-xl p-8 border border-muted hover:border-primary/50 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 flex flex-col justify-between min-h-80">

        <div class="absolute top-6 right-6 lg:opacity-40 group-hover:opacity-100 transition-opacity">
            <div class="px-2 py-1 bg-primary/10 backdrop-blur-md rounded-xl border border-primary/20 shadow-sm flex items-center gap-2">
                <span class="text-[10px] font-bold text-primary tracking-widest">{{ $verb->level }}</span>
            </div>
        </div>

        <div>
            <h3 class="text-3xl font-bold text-body group-hover:text-primary transition-colors mb-2 uppercase ">
                {{ $verb->infinitive }}
            </h3>
            <p class="text-xs font-bold text-muted tracking-widest mb-6">{{ __('Verbe irrégulier') }}</p>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-app rounded-2xl border border-muted group-hover:bg-white/50 transition-colors">
                    <span class="text-[10px] font-bold text-muted">{{ __('Past Simple') }}</span>
                    <span class="text-sm font-bold text-body">{{ Str::title($verb->past_simple) }}</span>
                </div>
                <div
                    class="flex items-center justify-between p-4 bg-app rounded-2xl border border-muted group-hover:bg-white/50 transition-colors">
                    <span class="text-[10px] font-bold text-muted">{{ __('Past Participle') }}</span>
                    <span
                        class="text-sm font-bold text-body">{{ Str::title($verb->past_participle ?? $verb->past_simple) }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <a href="{{ route('verbs.show', $verb->slug) }}" wire:navigate
                class="flex-1 py-4 bg-primary text-surface text-center text-xs font-bold rounded-2xl uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                {{ __('Détails du verbe') }}
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full py-32 text-center card-surface rounded-[3rem] border-2 border-dashed border-muted flex flex-col items-center justify-center">
        <div class="text-6xl mb-6 opacity-20">✨</div>
        <h3 class="text-2xl font-bold text-body uppercase ">{{ __('Magnifique !') }}</h3>
        <p class="text-muted mb-10 max-w-sm mx-auto font-medium">
            {{ __('Tu as terminé tous tes verbes prévus. Reviens demain pour de nouveaux défis.') }}
        </p>
        <a href="{{ route('verbs.index') }}" wire:navigate
            class="px-10 py-4 bg-body text-surface font-bold rounded-xl uppercase text-xs tracking-widest hover:scale-105 transition-all active:scale-95 shadow-xl">
            {{ __('Parcourir la bibliothèque') }}
        </a>
    </div>
    @endforelse
</div>
    </div>
</x-app-layout>
