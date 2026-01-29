@section('og_title', "Verbe : " . ucfirst($verb->infinitive))
@section('og_description', "Apprends le verbe '" . $verb->infinitive . "' sur IrreguLearn. Formes : " . $verb->past_simple . ", " . $verb->past_participle)
@section('og_image', route('share.image', ['type' => 'verb', 'identifier' => $verb->slug]))
<x-app-layout>
    <div x-data="{
        touchstartX: 0,
        touchendX: 0,
        handleSwipe() {
            if (this.touchendX < this.touchstartX - 80) {
                @if ($next) window.location.href = '{{ route('verbs.show', $next->slug) }}' @endif
            }
            if (this.touchendX > this.touchstartX + 80) {
                @if($previous)
                window.location.href = '{{ route('verbs.show', $previous->slug) }}'
                @endif
            }
        },
        speak(text) {
            let u = new SpeechSynthesisUtterance(text);
            u.lang = 'en-GB';
            speechSynthesis.speak(u);
        }
    }" @touchstart="touchstartX = $event.changedTouches[0].screenX"
        @touchend="touchendX = $event.changedTouches[0].screenX; handleSwipe()" class="py-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Hero Header -->
        <div class="mb-6 md:mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-body mb-4">
                {{ $verb->infinitive }}
            </h1>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button @click="speak('{{ $verb->infinitive }}')" class="p-2 rounded-full bg-white active:scale-95 transition text-primary">
                        <x-lucide-volume-2 class="size-5 stroke-current"/>
                    </button>
                    <span class="text-lg font-bold text-muted italic">{{ $verb->phonetic ?? '...' }}</span>
                </div>
                <div class="w-auto flex flex-row gap-3">
                    <x-share-button :title=" __('To') . $verb->infinitive" :text="__('Le verbe To ') . $verb->slug . __(' sur Irregulearn')" :url="route('verbs.show', $verb->slug)" />
                    @php $verbId = $verb->id; @endphp
                    <livewire:add-to-favs-button :$verbId />
                </div>
            </div>
        </div>

        <div class="space-y-8 relative z-20">
            <!-- Basic Forms Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Past Simple -->
                <div class="card-surface p-4 rounded-xl border border-muted group hover:border-primary transition-all duration-500">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-muted uppercase ">Past Simple</span>
                        <button @click="speak('{{ $verb->past_simple }}')" class="p-2 rounded-xl bg-app text-muted hover:text-primary transition">
                            <x-lucide-volume-2 class="size-5 stroke-current" />
                        </button>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-body">
                        {{ str_replace('/', ' / ', $verb->past_simple) }}
                    </h2>
                </div>

                <!-- Past Participle -->
                <div class="card-surface p-4 rounded-xl border border-muted hover:border-success transition-all duration-500">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-muted uppercase ">Past Participle</span>
                        <button @click="speak('{{ $verb->past_participle }}')" class="p-2 rounded-xl bg-app text-muted hover:text-success transition">
                            <x-lucide-volume-2 class="size-5 stroke-current" />
                        </button>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-body">
                        {{ str_replace('/', ' / ', $verb->past_participle) }}
                    </h2>
                </div>
            </div>

            <!-- Meaning & Description -->
            <div class="card-surface p-6 md:p-8 rounded-xl border border-muted">
                <h3 class="text-2xl font-bold text-body mb-6 flex items-center gap-3">
                    <span class="w-2 h-8 bg-primary rounded-full"></span>
                    {{ __('Signification & Usage') }}
                </h3>
                <div class="prose prose-indigo max-w-none">
                    <p class="text-lg md:text-xl text-body/90 font-medium leading-relaxed">
                        <ul>
                        @forelse ($verb->description as $desc)
                            <li>{{ Str::ucfirst(trim($desc)) }}</li>
                        @empty
                            <li>{{ __('Pas de description disponible pour le moment.') }}</li>
                        @endforelse
                        </ul>
                    </p>
                </div>

                <div class="flex flex-row gap-2 items-center justify-between mt-4 pt-4 border-t border-muted/50">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-[10px] font-bold text-muted uppercase ">
                            {{ __('Traduction :') }}
                        </span>
                        @if (app()->getLocale() !== "en")
                        <!-- Translation box -->
                        @php
                        $verbTranslation = $verb->translations()->where('lang_code', app()->getLocale())->first();
                        @endphp
                        <span class="text-body rounded-xl font-bold text-sm uppercase">
                            {{ $verbTranslation->translation }}
                        </span>
                        @endif
                    </div>
                <a href="{{ $verb->source_url . '#English' }}" target="_blank"
                    class="px-4 py-2 bg-surface border-2 border-primary/20 text-primary rounded-2xl font-bold text-[10px] hover:bg-primary hover:text-surface transition-all active:scale-95">
                    {{ __('En savoir plus') }}
                </a>
                </div>
            </div>

            <!-- Usage Examples -->
            @php $sentences = $verb->sentences()->take(3)->get(); @endphp
            <div class="space-y-4">
                <h3 class="text-2xl font-bold text-body px-4">{{ __('Exemples d\'utilisation') }}</h3>
            @if($sentences->count() > 0)
                <ul class="grid grid-cols-1 gap-4">
                    @foreach($sentences as $sentence)
                    <li class="card-surface p-4 rounded-xl border border-muted flex items-start justify-between gap-4 group hover:bg-primary/5 transition-all">
                        <span class="text-body font-medium leading-relaxed">
                            {{ Str::ucfirst(trim($sentence->sentence)) }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            @else
            <div class="flex flex-col items-center gap-4">
                <x-lucide-wind class="size-8 md:size-10 text-muted" />
                <p class="text-center">
                    {{ __("Il n'y a pas encore d'exemple disponible pour ce verbe.") }}<br>
                    {{ __("Regarde du coté de la communauté et ecris-en un") }}
                </p>
            </div>
            @endif
            </div>

            <!-- Discussion Section -->
            <div class="pt-8">
                <livewire:verb-discussion :verb="$verb" />
            </div>
        </div>
    </div>

    <!-- Navigation Overlay -->
    <div class="hidden md:flex fixed inset-y-0 left-0 right-0 pointer-events-none items-center justify-between px-8 z-40">
        @if ($previous)
            <a href="{{ route('verbs.show', $previous->slug) }}" wire:navigate
                class="pointer-events-auto p-4 rounded-3xl bg-white/50 backdrop-blur-md border border-white/20 text-body transition-all hover:scale-110 hover:bg-white active:scale-95 shadow-2xl group"
                title="{{ __('Précédent :') }} {{ $previous->infinitive }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @else
            <div></div>
        @endif

        @if ($next)
            <a href="{{ route('verbs.show', $next->slug) }}" wire:navigate
                class="pointer-events-auto p-4 rounded-3xl bg-white/50 backdrop-blur-md border border-white/20 text-body transition-all hover:scale-110 hover:bg-white active:scale-95 shadow-2xl group"
                title="{{ __('Suivant :') }} {{ $next->infinitive }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @endif
    </div>

    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === "ArrowLeft") {
                @if ($previous) window.location.href = "{{ route('verbs.show', $previous->slug) }}"; @endif
            }
            if (e.key === "ArrowRight") {
                @if ($next) window.location.href = "{{ route('verbs.show', $next->slug) }}"; @endif
            }
        });
    </script>
</x-app-layout>
