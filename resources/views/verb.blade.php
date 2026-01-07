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
        @touchend="touchendX = $event.changedTouches[0].screenX; handleSwipe()" class="min-h-screen bg-app pb-20">

        <!-- Hero Header -->
        <div class="relative bg-gradient-to-b from-primary/10 to-transparent pt-12 pb-24 overflow-hidden">
            <div class="max-w-4xl mx-auto px-6 relative z-10">
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-8">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-4">
                            <span>🇬🇧</span> English Irregular Verb
                        </div>
                        <h1 class="text-6xl md:text-8xl font-black text-body tracking-tighter uppercase mb-4 leading-none">
                            {{ $verb->infinitive }}
                        </h1>
                        <div class="flex items-center gap-3">
                            <button @click="speak('{{ $verb->infinitive }}')" class="p-3 rounded-full bg-white shadow-xl hover:scale-110 active:scale-95 transition text-primary">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.85 14,18.71V20.77C18.01,19.86 21,16.28 21,12C21,7.72 18.01,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16.02C15.5,15.29 16.5,13.77 16.5,12M3,9V15H7L12,20V4L7,9H3Z"/></svg>
                            </button>
                            <span class="text-xl font-bold text-muted italic">{{ $verb->phonetic ?? '...' }}</span>
                        </div>
                    </div>

                    <div class="w-auto flex flex-row md:flex-col gap-3">
                        <button x-data="{ copied: false }" @click="navigator.clipboard.writeText('{{ route('verbs.show', $verb->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="inline-flex flex-row justify-center font-bold items-center gap-2 px-6 py-3 rounded-lg bg-surface border border-muted text-body text-sm hover:bg-muted/5 transition active:scale-95 shadow-sm">
                            <span x-show="!copied">🔗 Partager</span>
                            <span x-show="copied" x-cloak class="text-success">✅ Lien copié !</span>
                        </button>
                        <livewire:add-to-favs-button :$verb />
                    </div>
                </div>
            </div>
            <!-- Background Decoration -->
            <div class="absolute -right-20 -top-20 text-[20rem] font-black text-primary opacity-[0.03] pointer-events-none select-none">
                {{ substr($verb->infinitive, 0, 1) }}
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-6 -mt-12 space-y-8 relative z-20">
            <!-- Basic Forms Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Past Simple -->
                <div class="card-surface p-8 rounded-[2.5rem] border border-muted shadow-xl group hover:border-primary transition-all duration-500">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black text-muted uppercase tracking-[0.2em]">Past Simple</span>
                        <button @click="speak('{{ $verb->past_simple }}')" class="p-2 rounded-xl bg-app text-muted hover:text-primary transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.85 14,18.71V20.77C18.01,19.86 21,16.28 21,12C21,7.72 18.01,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16.02C15.5,15.29 16.5,13.77 16.5,12M3,9V15H7L12,20V4L7,9H3Z"/></svg>
                        </button>
                    </div>
                    <p class="text-4xl font-black text-body group-hover:text-primary transition-colors">
                        {{ str_replace('/', ' / ', $verb->past_simple) }}
                    </p>
                </div>

                <!-- Past Participle -->
                <div class="card-surface p-8 rounded-[2.5rem] border border-muted shadow-xl group hover:border-success transition-all duration-500">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black text-muted uppercase tracking-[0.2em]">Past Participle</span>
                        <button @click="speak('{{ $verb->past_participle }}')" class="p-2 rounded-xl bg-app text-muted hover:text-success transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.85 14,18.71V20.77C18.01,19.86 21,16.28 21,12C21,7.72 18.01,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16.02C15.5,15.29 16.5,13.77 16.5,12M3,9V15H7L12,20V4L7,9H3Z"/></svg>
                        </button>
                    </div>
                    <p class="text-4xl font-black text-body group-hover:text-success transition-colors">
                        {{ str_replace('/', ' / ', $verb->past_participle) }}
                    </p>
                </div>
            </div>

            <!-- Meaning & Description -->
            <div class="card-surface p-8 md:p-12 rounded-[3rem] border border-muted shadow-xl bg-gradient-to-br from-muted to-primary/5">
                <h3 class="text-2xl font-black text-body mb-6 flex items-center gap-3">
                    <span class="w-2 h-8 bg-primary rounded-full"></span>
                    Signification & Usage
                </h3>
                <div class="prose prose-indigo max-w-none">
                    <p class="text-lg md:text-xl text-body/90 font-medium leading-relaxed italic">
                        @forelse ($verb->description as $desc)
                            <p>{{ $desc }}</p>
                        @empty
                            Pas de description disponible pour le moment.
                        @endforelse
                    </p>
                </div>

                @if (app()->getLocale() !== "en")
                    <!-- Translation box -->
                    @php
                        $verbTranslation = $verb->translations()->where('lang_code', app()->getLocale())->first();
                    @endphp
                    <div class="mt-4 pt-4 border-t border-muted/50 flex flex-wrap gap-2 items-center">
                        <span class="text-[10px] font-bold text-muted uppercase tracking-[0.2em]">
                            Traduction:
                        </span>
                        <span class="text-body rounded-xl font-black text-sm uppercase">
                            {{ $verbTranslation->translation }}
                        </span>
                    </div>
                @endif
            </div>
            <a href="{{ $verb->source_url }}"
                class="shrink-0 px-10 py-5 bg-white text-primary rounded-[2rem] font-black text-base hover:scale-105 transition shadow-2xl active:scale-95">
                En savoir plus
            </a>

            <!-- Usage Examples -->
            @php $sentences = $verb->sentences()->take(3)->get(); @endphp
            @if($sentences->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-xl font-black text-body uppercase tracking-tight px-4">Exemples d'utilisation</h3>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($sentences as $sentence)
                            <div class="card-surface p-6 rounded-2xl border border-muted flex items-start justify-between gap-4 group hover:bg-primary/5 transition-all">
                                <p class="text-body font-medium leading-relaxed">
                                    {!! str_replace($sentence->missing_word, '<span class="text-primary font-black underline">' . $sentence->missing_word . '</span>', $sentence->sentence) !!}
                                </p>
                                <button @click="speak('{{ addslashes($sentence->sentence) }}')" class="shrink-0 p-2 rounded-lg bg-app text-muted opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.85 14,18.71V20.77C18.01,19.86 21,16.28 21,12C21,7.72 18.01,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16.02C15.5,15.29 16.5,13.77 16.5,12M3,9V15H7L12,20V4L7,9H3Z"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Discussion Section -->
            <div class="pt-8">
                <livewire:verb-discussion :verb="$verb" />
            </div>
        </div>
    </div>

    <!-- Navigation Overlay -->
    <div class="hidden md:flex fixed inset-y-0 left-0 right-0 pointer-events-none items-center justify-between px-8 z-40">
        @if ($previous)
            <a href="{{ route('verbs.show', $previous->slug) }}"
                class="pointer-events-auto p-4 rounded-3xl bg-white/50 backdrop-blur-md border border-white/20 text-body transition-all hover:scale-110 hover:bg-white active:scale-95 shadow-2xl group"
                title="Précédent : {{ $previous->infinitive }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @else
            <div></div>
        @endif

        @if ($next)
            <a href="{{ route('verbs.show', $next->slug) }}"
                class="pointer-events-auto p-4 rounded-3xl bg-white/50 backdrop-blur-md border border-white/20 text-body transition-all hover:scale-110 hover:bg-white active:scale-95 shadow-2xl group"
                title="Suivant : {{ $next->infinitive }}">
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