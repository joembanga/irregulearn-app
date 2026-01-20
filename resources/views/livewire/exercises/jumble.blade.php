<div class="text-center space-y-6 md:space-y-10">
    <!-- Drop Zone -->
    <div class="flex flex-wrap justify-center gap-2 md:gap-3 min-h-12 md:min-h-15 p-2 md:p-4 bg-app rounded-xl border transition-colors {{ $isCorrect === true ? 'border-success text-success' : ($isCorrect === false ? 'border-danger text-danger' : 'border-muted') }} {{ count($selectedLetters) > 0 ? 'border-primary/20 bg-primary/5' : '' }}">
        @forelse($selectedLetters as $index => $letter)
            <button wire:key="selected-{{ $currentVerb->id }}-{{ $index }}" 
                wire:click="unselectLetter({{ $index }})"
                class="w-8 h-8 md:w-12 md:h-12 rounded-sm lg:roundend-lg bg-primary text-surface font-bold text-xl lg:text-2xl shadow-xl transition-all duration-300 hover:-translate-y-1 active:scale-90 animate-bounce-in">
                {{ $letter }}
            </button>
        @empty
            <div class="w-full h-full flex items-center justify-center text-muted font-bold text-xs lg:text-sm py-3">
                Appuie sur les lettres pour former le mot...
            </div>
        @endforelse
    </div>

    <!-- Letter Bank -->
    <div class="flex flex-wrap justify-center gap-3">
        @foreach($jumbledLetters as $index => $letter)
            <button wire:key="jumble-{{ $currentVerb->id }}-{{ $index }}"
                wire:click="selectLetter({{ $index }})"
                class="w-8 h-8 md:w-12 md:h-12 rounded-sm lg:roundend-lg bg-surface md:border border-b-2 md:border-b-4 border-muted text-body font-bold text-xl md:text-2xl transition-all duration-300 active:border-b-0 active:translate-y-1 active:scale-95 shadow-xl">
                {{ $letter }}
            </button>
        @endforeach
    </div>

    @if($isCorrect === null && count($selectedLetters) > 0)
        <button wire:click="checkAnswer"
            class="w-[70%] py-3 md:py-4 bg-primary text-surface uppercase rounded-xl font-bold text-base md:text-lg tracking-[0.2em] shadow-xl transition-all hover:scale-[1.03] active:scale-95">
            Vérifier
        </button>
    @endif
</div>
