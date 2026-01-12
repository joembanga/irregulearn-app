<div class="space-y-8">
    <div class="bg-primary/5 p-8 md:p-12 rounded-[2.5rem] text-center border-2 border-primary/10 shadow-inner relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14,17H17L19,13V7H13V13H16L14,17M6,17H9L11,13V7H5V13H8L6,17Z"/></svg>
        </div>
        <p class="text-xl md:text-2xl font-medium leading-relaxed text-body font-serif italic relative z-10">
            "{!! nl2br(e(ucfirst($currentSentence))) !!}"
        </p>
    </div>

    <div class="space-y-6">
        <input wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
            class="w-full text-center py-8 px-6 bg-app border-4 rounded-[2rem] text-3xl font-black uppercase tracking-widest focus:outline-none focus:ring-0 transition-all duration-500 {{ $isCorrect === true ? 'border-success text-success shadow-xl shadow-success/10' : ($isCorrect === false ? 'border-danger text-danger shadow-xl shadow-danger/10' : 'border-muted focus:border-primary') }}" 
            placeholder="Le mot manquant..." 
            {{ $isCorrect !== null ? 'disabled' : '' }} 
            autofocus>

        @if($isCorrect === null)
        <button wire:click="checkAnswer"
            class="w-full py-6 bg-primary text-surface rounded-[2rem] font-black text-lg uppercase tracking-[0.2em] shadow-2xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-95">
            Confirmer ma réponse
        </button>
        @endif
    </div>
</div>