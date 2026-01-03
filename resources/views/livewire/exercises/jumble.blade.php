<div class="text-center space-y-8">
    <div class="flex flex-wrap justify-center gap-2 min-h-[60px]">
        @foreach($selectedLetters as $index => $letter)
        <button wire:key="selected-{{ $currentVerb->id }}-{{ $currentIndex }}" wire:click="unselectLetter({{ $index }})"
            class="w-12 h-12 rounded-xl bg-primary text-surface font-bold text-xl shadow-lg transform hover:-translate-y-1 transition">
            {{ $letter }}
        </button>
        @endforeach
        @if(count($selectedLetters) === 0)
        <div class="w-full text-muted italic text-sm py-4">Clique sur les lettres ci-dessous</div>
        @endif
    </div>

    <div class="flex flex-wrap justify-center gap-2">
        @foreach($jumbledLetters as $index => $letter)
        <button wire:click="selectLetter({{ $index }})"
            class="w-12 h-12 rounded-xl bg-surface border-b-4 border-muted text-muted font-bold text-xl hover:bg-primary-10 active:border-b-0 active:translate-y-1 transition">
            {{ $letter }}
        </button>
        @endforeach
    </div>

    @if($isCorrect === null && count($selectedLetters) > 0)
    <button wire:click="checkAnswer"
        class="px-8 py-3 bg-primary text-surface rounded-full font-bold shadow-lg transition">
        Vérifier
    </button>
    @endif
</div>