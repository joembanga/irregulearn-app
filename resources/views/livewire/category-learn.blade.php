<div class="py-12 max-w-xl mx-auto px-4">
    @if(!$finished)
    <div
        class="bg-surface rounded-3xl shadow-2xl p-8 border border-muted relative overflow-hidden">

        <div class="absolute top-0 left-0 h-1 bg-primary transition-all duration-500"
            style="width: {{ (($currentIndex) / count($verbs)) * 100 }}%">
        </div>

        <div class="flex justify-between items-center mb-8">
            <span class="text-xs font-bold tracking-widest text-primary uppercase">{{ $category->name }}</span>
            <span class="text-xs font-bold text-muted">QUESTION <span class="text-muted">{{ $currentIndex + 1 }}/{{ count($verbs) }}</span></span>
        </div>

        @if($currentType === 'odd_one_out')
        @include('livewire.exercises.odd_one_out')
        @elseif($currentType === 'complete')
        @include('livewire.exercises.complete')
        @else
        <div class="text-center mb-10">
            <p class="text-sm text-muted mb-2 uppercase">
                Conjugue au <span class="text-primary font-bold">{{ str_replace('_', ' ', $currentTargetForm) }}</span>
            </p>
            <h2 class="text-5xl font-black text-body mb-2 tracking-tight flex items-center justify-center gap-4">
                {{ $currentVerb->infinitive }}
                <button onclick="let u = new SpeechSynthesisUtterance('{{ $currentVerb->infinitive }}'); u.lang='en-GB'; speechSynthesis.speak(u);"
                    class="p-2 rounded-full bg-surface hover:bg-primary-10 text-muted hover:text-primary transition shadow-sm"
                    title="Écouter la prononciation">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                </button>
            </h2>
        </div>

        <div class="min-h-[200px] flex flex-col justify-center">
            {{-- TYPE 1 : INPUT CLASSIQUE --}}
            @if($currentType === 'input')
            @include('livewire.exercises.input')
            {{-- TYPE 2 : QUIZ (QCM) --}}
            @elseif($currentType === 'quiz')
            @include('livewire.exercises.quiz')
            {{-- TYPE 3 : JUMBLE (Méli-mélo) --}}
            @elseif($currentType === 'jumble')
            @include('livewire.exercises.jumble')
            {{-- TYPE 4 : SENTENCE (Phrase à trous) --}}
            @elseif($currentType === 'sentence')
            @include('livewire.exercises.sentence')
            @endif
        </div>
        @endif

        @if($isCorrect !== null)
        <div class="mt-8 pt-6 border-t border-muted animate-fade-in-up">
            @if($isCorrect)
            <div class="flex items-center text-success font-bold mb-4">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Bonne réponse ! (+10 XP)
            </div>
            @else
            <div class="flex flex-col text-danger font-bold mb-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Faux !
                </div>
                <span class="text-muted text-sm mt-1">
                    La réponse était : <span class="text-primary font-bold">
                        {{ str_replace('/', ' ou enocre ', $answer) }}
                    </span>
                </span>
            </div>
            @endif

            <button wire:click="nextVerb" class="w-full py-4 btn-invert rounded-2xl font-bold text-lg hover:opacity-90 transition shadow-lg">
                Question Suivante →
            </button>
        </div>
        @endif

    </div>
    @else
    <div class="text-center bg-surface rounded-3xl p-12 shadow-xl border border-muted">
        <div class="text-7xl mb-6">🏆</div>
        <h2 class="text-3xl font-black text-body mb-4">Session Terminée !</h2>
        <p class="text-muted mb-8 text-lg">
            Tu as gagné <span class="text-primary font-bold">{{ $finished_reward }} XP</span> bonus.
        </p>
        <a href="{{ route('learn') }}"
            class="inline-flex items-center px-8 py-4 bg-primary text-surface rounded-2xl font-bold shadow-lg hover:opacity-95 transition">
            Retour au parcours
        </a>
    </div>
    @endif
</div>