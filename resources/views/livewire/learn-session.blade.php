<div class="min-h-screen bg-app py-6 md:py-12 flex flex-col items-center justify-center relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    <div class="w-full max-w-2xl px-6 relative z-10">
        @if (!$finished)
            <!-- Progress visualization -->
            <div class="mb-10 space-y-4">
                <div class="flex items-center justify-between px-2">
                    <span class="text-[10px] font-black text-muted uppercase tracking-[0.2em]">
                        {{ $mode === 'category' ? $category->name : ($mode === 'daily' ? 'Verbes du jour' : 'Entraînement') }}
                    </span>
                    <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">
                        {{ $currentIndex + 1 }} / {{ count($verbs) }}
                    </span>
                </div>
                <div class="h-3 w-full bg-surface rounded-full p-1 shadow-inner border border-muted/30">
                    <div class="h-full bg-gradient-to-r from-primary to-indigo-500 rounded-full transition-all duration-700 ease-out shadow-lg shadow-primary/20"
                        style="width: {{ (($currentIndex) / count($verbs)) * 100 }}%">
                    </div>
                </div>
            </div>

            <div class="card-surface rounded-[3rem] shadow-2xl p-8 md:p-12 border border-muted relative group transition-all duration-500 {{ $isCorrect === true ? 'border-success/30 shadow-success/10' : ($isCorrect === false ? 'border-danger/30 shadow-danger/10' : '') }}">
                
                @if ($currentType === 'odd_one_out')
                    @include('livewire.exercises.odd_one_out')
                @elseif($currentType === 'complete')
                    @include('livewire.exercises.complete')
                @elseif($currentType === 'sentence')
                    <div class="text-center mb-12">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-500 text-[10px] font-black uppercase tracking-widest mb-6">
                            ⚡ Exercice de contexte
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black text-body mb-2 tracking-tighter uppercase">
                            {{ $currentVerb->infinitive }}
                        </h2>
                    </div>
                    @include('livewire.exercises.sentence')
                @else
                    <div class="text-center mb-12">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-6">
                            🎯 Forme : {{ str_replace('_', ' ', $currentTargetForm) }}
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black text-body mb-2 tracking-tighter uppercase flex items-center justify-center gap-4">
                            {{ $currentVerb->infinitive }}
                            <button @click="let u = new SpeechSynthesisUtterance('{{ $currentVerb->infinitive }}'); u.lang='en-GB'; speechSynthesis.speak(u);"
                                class="p-3 rounded-2xl bg-app text-muted hover:text-primary transition-all hover:scale-110 active:scale-95 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                                    </path>
                                </svg>
                            </button>
                        </h2>
                    </div>

                    <div class="min-h-[200px] flex flex-col justify-center">
                        @if ($currentType === 'input')
                            @include('livewire.exercises.input')
                        @elseif($currentType === 'quiz')
                            @include('livewire.exercises.quiz')
                        @elseif($currentType === 'jumble')
                            @include('livewire.exercises.jumble')
                        @endif
                    </div>
                @endif

                <!-- Feedback Layout -->
                @if ($isCorrect !== null)
                    <div class="mt-12 pt-10 border-t border-muted animate-fade-in-up">
                        @if ($isCorrect)
                            <div class="flex items-center gap-4 text-success mb-8 bg-success/5 p-6 rounded-[2rem] border border-success/20">
                                <div class="w-12 h-12 bg-success text-surface rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-success/20">
                                    ✓
                                </div>
                                <div>
                                    <p class="font-black text-lg uppercase tracking-tight">C'est juste !</p>
                                    <p class="text-sm font-bold opacity-80 uppercase tracking-widest">+10 XP RÉCUPÉRÉS</p>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col gap-4 text-danger mb-8 bg-danger/5 p-6 rounded-[2rem] border border-danger/20">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-danger text-surface rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-danger/20">
                                        ✕
                                    </div>
                                    <div>
                                        <p class="font-black text-lg uppercase tracking-tight">Oups, pas tout à fait...</p>
                                        <p class="text-xs font-bold opacity-80 uppercase tracking-widest">CONTINUE D'ESSAYER !</p>
                                    </div>
                                </div>
                                <div class="mt-2 p-4 bg-app rounded-xl border border-muted/50">
                                    <p class="text-[10px] font-bold text-muted uppercase mb-1">La bonne réponse :</p>
                                    <p class="text-2xl font-black text-primary uppercase tracking-tight">
                                        {{ str_replace('/', ' / ', $answer) }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <button wire:click="nextVerb" class="w-full py-6 bg-primary text-surface rounded-[2rem] font-black text-lg uppercase tracking-[0.2em] transition-all hover:scale-[1.02] active:scale-95 shadow-2xl hover:bg-primary">
                            Continuer →
                        </button>
                    </div>
                @endif
            </div>
        @else
            <!-- Success/Finished State -->
            <div class="text-center bg-surface rounded-[4rem] p-12 md:p-20 shadow-2xl border border-muted relative overflow-hidden group">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl transition-transform group-hover:scale-150 duration-1000"></div>
                
                <div class="relative z-10">
                    <div class="text-[8rem] mb-8 animate-bounce transition-transform duration-500">🏆</div>
                    <h2 class="text-4xl md:text-5xl font-black text-body mb-4 uppercase tracking-tighter">Bien joué !</h2>
                    <p class="text-muted mb-12 text-lg font-medium leading-relaxed">
                        Session terminée avec brio. <br> Tu as récolté un bonus de <span class="text-primary font-black ml-1">{{ $finished_reward }} XP</span>.
                    </p>
                    <a href="{{ route('learn.index') }}"
                        class="inline-flex items-center px-12 py-5 bg-primary text-surface rounded-[2rem] font-black text-base uppercase tracking-[0.2em] transition-all hover:scale-110 active:scale-95 shadow-2xl shadow-primary/30">
                        RETOUR AU PARCOURS
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>