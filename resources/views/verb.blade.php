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
        }
    }" @touchstart="touchstartX = $event.changedTouches[0].screenX"
        @touchend="touchendX = $event.changedTouches[0].screenX; handleSwipe()" class="min-h-screen bg-app py-8">
        <div class="max-w-4xl mx-auto px-6">
            <div class="card-surface rounded-2xl p-6 shadow-lg border border-muted">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-2.5 h-20 md:h-28 rounded-md bg-primary shrink-0"></div>
                        <div>
                            <h2 class="text-2xl md:text-3xl font-extrabold text-body break-all">{{ $verb->infinitive }}
                            </h2>
                            @if ($verb->description)
                                <p class="mt-2 text-xs md:text-sm text-body/80 max-w-xl italic border-l-2 border-primary/30 pl-3">
                                    {{ $verb->description }}
                                </p>
                            @endif
                            <p class="mt-1 text-xs md:text-sm text-muted italic">Exemple: "I
                                <strong>{{ $verb->past_simple }}</strong> to the market yesterday."
                            </p>
                        </div>
                    </div>

                    <div class="md:ms-auto flex flex-col gap-3 w-full md:w-auto">
                        <div class="md:ms-auto flex flex-wrap gap-3">
                            <div class="px-4 py-2 bg-primary-10 text-primary rounded-lg font-mono font-bold text-sm md:text-base text-center grow md:grow-0">
                                {{ str_replace('/', ' or ', $verb->past_simple) }}
                            </div>
                            <div class="px-4 py-2 bg-success-10 text-success rounded-lg font-mono font-bold text-sm md:text-base text-center grow md:grow-0">
                                {{ str_replace('/', ' or ', $verb->past_participle) }}
                            </div>
                        </div>
                        <div class="w-full md:w-auto">
                            <livewire:add-to-favs-button :$verb />
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-lg bg-surface">
                        <h4 class="font-semibold text-body mb-2">Conjugaison</h4>
                        <pre class="font-mono text-sm text-muted">{{ $verb->conjugation ?? '—' }}
                        </pre>
                    </div>
                    <div class="p-4 rounded-lg bg-surface">
                        <h4 class="font-semibold text-body mb-2">Notes</h4>
                        <p class="text-sm text-muted">{{ $verb->notes ?? 'Aucune note.' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <livewire:verb-discussion :verb="$verb" />
            </div>
        </div>
    </div>
    <div class="hidden md:flex fixed inset-y-0 left-0 right-0 pointer-events-none items-center justify-between px-4 z-40">

        @if ($previous)
            <a href="{{ route('verbs.show', $previous->slug) }}"
                class="pointer-events-auto p-3 rounded-full glass border border-muted text-body hover:scale-110 transition-all shadow-xl group"
                title="Précédent : {{ $previous->infinitive }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @else
            <div></div>
        @endif

        @if ($next)
            <a href="{{ route('verbs.show', $next->slug) }}"
                class="pointer-events-auto p-3 rounded-full glass border border-muted text-body hover:scale-110 transition-all shadow-xl group"
                title="Suivant : {{ $next->infinitive }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @endif
    </div>
    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === "ArrowLeft") {
                @if ($previous)
                    window.location.href = "{{ route('verbs.show', $previous->slug) }}";
                @endif
            }
            if (e.key === "ArrowRight") {
                @if ($next)
                    window.location.href = "{{ route('verbs.show', $next->slug) }}";
                @endif
            }
        });
    </script>
</x-app-layout>