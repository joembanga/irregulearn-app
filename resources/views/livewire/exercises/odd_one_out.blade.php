<div class="text-center">
    <div class="mb-12">
        <h3 class="text-2xl font-black text-body uppercase tracking-tight">Trouve l'intrus</h3>
        <p class="text-xs font-bold text-muted uppercase tracking-widest mt-2">Un de ces verbes ne suit pas la même logique</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($choices as $choice)
        <button 
            wire:key="odd-{{ $currentVerb->id }}-{{ $currentIndex }}-{{ $loop->index }}" 
            wire:click="checkAnswer('{{ $choice }}')"
            class="group p-8 rounded-[2rem] font-black text-xl border-4 transition-all duration-500 hover:scale-105 active:scale-95 flex flex-col items-center justify-center gap-2
            {{ $isCorrect !== null && strtolower($choice) === strtolower($answer) ? 'bg-success border-success text-surface shadow-xl shadow-success/20' : 
               ($isCorrect === false && strtolower($choice) === strtolower($userInput) ? 'bg-danger border-danger text-surface shadow-xl shadow-danger/20' : 
               ($isCorrect !== null ? 'bg-surface border-muted text-muted opacity-50 cursor-not-allowed' : 'bg-surface border-muted text-body hover:border-primary hover:text-primary hover:shadow-xl hover:shadow-primary/5')) }}">
            <span class="uppercase tracking-tighter">{{ $choice }}</span>
        </button>
        @endforeach
    </div>
</div>