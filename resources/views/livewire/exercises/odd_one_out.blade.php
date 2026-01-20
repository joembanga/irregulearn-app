<div class="text-center">
    <div class="mb-6 md:mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-body uppercase tracking-tight">Trouve l'intrus</h2>
        <p class="text-xs md:text-sm font-bold text-muted tracking-widest mt-2">Un de ces verbes n'est pas censé se retrouver ici</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        @foreach($choices as $choice)
        <button wire:key="odd-{{ $currentVerb->id }}-{{ $currentIndex }}-{{ $loop->index }}"
            wire:click="checkAnswer('{{ $choice }}')"
            class="border-muted bg-surface text-body text-center tracking-tight group p-4 md:p-6 rounded-xl capitalize font-bold text-md md:text-lg border-2 transition-all hover:scale-102 active:scale-95 flex flex-col items-center justify-center gap-1 md:gap-2
            {{ $isCorrect !== null && strtolower($choice) === strtolower($answer) ? 'border-success text-success' :
               ($isCorrect === false && strtolower($choice) === strtolower($userInput) ? 'border-danger text-danger' :
               ($isCorrect !== null ? 'bg-surface border-muted text-muted opacity-50' : 'bg-surface border-muted text-body hover:shadow-lg hover:shadow-primary/5')) }}"
               {{ $isCorrect === null ? '' : 'disabled'}} >
            <span class="tracking-tighter">{{ $choice }}</span>
        </button>
        @endforeach
    </div>
</div>
