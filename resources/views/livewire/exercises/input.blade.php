<div class="space-y-4">
    <input wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
        class="w-full text-center p-4 border-2 rounded-2xl text-2xl font-bold bg-surface focus:outline-none focus:ring-0 transition-colors {{ $isCorrect === true ? 'border-success bg-success-10 text-success' : ($isCorrect === false ? 'border-danger bg-danger-10 text-danger' : 'border-muted') }}" placeholder="Tape ta réponse..." {{ $isCorrect !== null ? 'disabled' : '' }} autofocus>
    @if($isCorrect === null)
    <button wire:click="checkAnswer"
        class="w-full py-4 bg-primary text-surface rounded-2xl font-bold text-lg shadow-lg transition-all duration-300 hover:scale-[1.02] active:scale-95">
        Valider
    </button>
    @endif
</div>