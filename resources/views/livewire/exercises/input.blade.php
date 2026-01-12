<div class="space-y-6">
    <div class="relative">
        <input wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
            class="w-full text-center py-8 px-6 bg-app border-4 rounded-[2rem] text-3xl font-black uppercase tracking-widest focus:outline-none focus:ring-0 transition-all duration-500 {{ $isCorrect === true ? 'border-success text-success shadow-xl shadow-success/10' : ($isCorrect === false ? 'border-danger text-danger shadow-xl shadow-danger/10' : 'border-muted focus:border-primary') }}"
            placeholder="Écris ici..."
            {{ $isCorrect !== null ? 'disabled' : '' }}
            autofocus>
    </div>
    
    @if($isCorrect === null)
    <button wire:click="checkAnswer"
        class="w-full py-6 bg-primary text-surface rounded-[2rem] font-black text-lg uppercase tracking-[0.2em] shadow-2xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-95">
        Valider la réponse
    </button>
    @endif
</div>
