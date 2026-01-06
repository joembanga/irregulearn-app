<div class="space-y-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($currentVerbForms as $label => $displayValue)
        <div class="flex flex-col gap-4">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-muted text-center">
                {{ str_replace('_', ' ', $label) }}
            </span>

            @if ($label === $removedForm)
            <div class="relative">
                <input wire:key="input-{{ $currentVerb->id }}-{{ $removedForm }}" wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
                    class="w-full text-center py-6 px-4 border-4 rounded-[2rem] text-xl font-black uppercase tracking-tight bg-app focus:outline-none transition-all duration-500 {{ $isCorrect === true ? 'border-success text-success shadow-lg shadow-success/10' : ($isCorrect === false ? 'border-danger text-danger shadow-lg shadow-danger/10' : 'border-muted focus:border-primary') }}"
                    placeholder="..." {{ $isCorrect !== null ? 'disabled' : '' }} autofocus >
            </div>
            @else
            <div
                class="py-6 px-4 min-h-[80px] rounded-[2rem] font-black text-xl border-4 border-muted/30 bg-surface/50 text-body/40 flex items-center justify-center text-center uppercase tracking-tight">
                {{ $displayValue }}
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @if($isCorrect === null)
    <button wire:click="checkAnswer"
        class="w-full py-6 bg-primary text-surface rounded-[2rem] font-black text-lg uppercase tracking-[0.2em] shadow-2xl shadow-primary/20 transition-all hover:scale-[1.02] active:scale-95">
        Vérifier la grille
    </button>
    @endif
</div>