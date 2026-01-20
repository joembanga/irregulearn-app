<div class="space-y-2 md:space-y-4">
    <div class="bg-primary/5 p-5 md:p-9 rounded-xl text-center border-2 border-primary/10 shadow-inner relative overflow-hidden mb-4">
        <div class="absolute top-0 right-0 p-2 md:p-4 opacity-10">
            <x-lucide-quote class="size-5 md:size-7 fill-current" />
        </div>
        <p class="text-xl md:text-2xl font-medium leading-relaxed text-body font-serif italic relative z-10">
            "{!! nl2br(e(ucfirst($currentSentence))) !!}"
        </p>
    </div>

    <div class="space-y-6 flex flex-col items-center justify-center">
        <input wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
            class="w-full text-center p-4 md:p-6 bg-app border-2 rounded-xl text-lg md:text-xl font-bold tracking-widest focus:outline-none focus:ring-0 transition-all duration-500 {{ $isCorrect === true ? 'border-success text-success' : ($isCorrect === false ? 'border-danger text-danger' : 'border-muted focus:border-primary') }}"
            placeholder="Le mot manquant..."
            {{ $isCorrect !== null ? 'disabled' : '' }}
            autofocus>

        @if($isCorrect === null)
        <button wire:click="checkAnswer"
            class="w-[70%] py-3 md:py-4 bg-primary text-surface rounded-xl font-bold text-base md:text-lg uppercase tracking-[0.2em] transition-all hover:scale-[1.02] active:scale-95 shadow-xl">
            Valider
        </button>
        @endif
    </div>
</div>
