<div class="space-y-6">
    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-2xl text-center border border-muted">
        <p class="text-xl font-medium leading-relaxed font-serif text-body text-pretty">
            "{!! nl2br(e($currentSentence)) !!}"
        </p>
    </div>

    <div class="space-y-4">
        <input wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
            class="w-full text-center p-4 border-2 rounded-2xl text-2xl font-bold bg-surface focus:outline-none focus:ring-0 transition-colors {{ $isCorrect === true ? 'border-success bg-success-10 text-success' : ($isCorrect === false ? 'border-danger bg-danger-10 text-danger' : 'border-muted') }}" placeholder="Mot manquant..." {{ $isCorrect !== null ? 'disabled' : '' }} autofocus>

        @if($isCorrect === null)
        <button wire:click="checkAnswer"
            class="w-full py-4 bg-primary text-surface rounded-2xl font-bold text-lg shadow-lg transition transform active:scale-95">
            Valider
        </button>
        @endif
    </div>
</div>