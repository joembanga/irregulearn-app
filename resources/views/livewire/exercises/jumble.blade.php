<div class="text-center space-y-12">
    <!-- Drop Zone -->
    <div class="flex flex-wrap justify-center gap-3 min-h-[80px] p-6 bg-app rounded-[2.5rem] border-4 border-dashed border-muted/50 transition-colors {{ count($selectedLetters) > 0 ? 'border-primary/20 bg-primary/5' : '' }}">
        @forelse($selectedLetters as $index => $letter)
            <button
                wire:key="selected-{{ $currentVerb->id }}-{{ $index }}" 
                wire:click="unselectLetter({{ $index }})"
                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-primary text-surface font-black text-2xl shadow-xl transition-all duration-300 hover:-translate-y-2 active:scale-90 animate-bounce-in uppercase">
                {{ $letter }}
            </button>
        @empty
            <div class="w-full h-full flex items-center justify-center text-muted/50 font-black text-xs uppercase tracking-widest italic py-4">
                Tape les lettres pour former le mot
            </div>
        @endforelse
    </div>

    <!-- Letter Bank -->
    <div class="flex flex-wrap justify-center gap-3">
        @foreach($jumbledLetters as $index => $letter)
            <button
                wire:key="jumble-{{ $currentVerb->id }}-{{ $index }}"
                wire:click="selectLetter({{ $index }})"
                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-surface border-b-8 border-muted text-body font-black text-2xl transition-all duration-300 hover:bg-white active:border-b-0 active:translate-y-2 active:scale-95 uppercase shadow-lg">
                {{ $letter }}
            </button>
        @endforeach
    </div>

    @if($isCorrect === null && count($selectedLetters) > 0)
        <button wire:click="checkAnswer"
            class="px-12 py-5 bg-primary text-surface rounded-[2rem] font-black text-base uppercase tracking-[0.2em] shadow-2xl shadow-primary/30 transition-all hover:scale-110 active:scale-95">
            Vérifier le mot
        </button>
    @endif
</div>
