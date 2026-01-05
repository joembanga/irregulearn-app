<div class="space-y-6">
    <div class="grid grid-cols-3 gap-3">
        @foreach($currentVerbForms as $label => $displayValue)
        <div class="flex flex-col gap-2">
            <span class="text-[10px] font-black uppercase tracking-tighter text-muted text-center">
                {{ str_replace('_', '', $label) }}
            </span>

            @if ($label === $removedForm)
            <input wire:key="input-{{ $currentVerb->id }}-{{ $removedForm }}" wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
                class="w-full text-center p-4 border-2 rounded-2xl text-lg font-bold bg-surface focus:ring-2 outline-none transition-all {{ $isCorrect === true ? 'border-success bg-success-10 text-success' : ($isCorrect === false ? 'border-danger bg-danger-10 text-danger' : 'border-muted') }}"
                placeholder="..." {{ $isCorrect !== null ? 'disabled' : '' }} autofocus >
            @else
            <div
                class="p-4 h-full min-h-[60px] rounded-2xl font-bold text-lg border-2 border-muted bg-surface text-muted flex items-center justify-center text-center">
                {{ $displayValue }}
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @if($isCorrect === null)
    <button wire:click="checkAnswer"
        class="w-full py-4 bg-primary text-surface rounded-2xl font-bold text-lg shadow-lg transition-all duration-300 hover:scale-[1.02] active:scale-95">
        Valider
    </button>
    @endif
</div>