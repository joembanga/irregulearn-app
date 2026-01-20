<div class="space-y-6 md:space-y-10 text-center">
    <div class="mb-6 md:mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-body uppercase tracking-tight">Complète la suite</h2>
        <p class="text-xs md:text-sm font-bold text-muted tracking-widest mt-2">Te rappelles tu de toutes les formes de ce verbe</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($currentVerbForms as $label => $displayValue)
        <div class="flex flex-col gap-3 items-center mb-2">
            <span class="text-[8px] lg:text-xs font-bold uppercase tracking-[0.2em] text-muted text-center">
                {{ str_replace('_', ' ', $label) }}
            </span>

            @if ($label === $removedForm)
            <input wire:key="input-{{ $currentVerb->id }}-{{ $removedForm }}" wire:model.defer="userInput" wire:keydown.enter="checkAnswer" type="text"
                class="w-[70%] md:w-full text-center py-3 md:py-4 px-4 border-2 rounded-xl text-md md:text-lg font-bold tracking-tight bg-app focus:outline-none transition-all duration-500 {{ $isCorrect === true ? 'border-success text-success' : ($isCorrect === false ? 'border-danger text-danger' : 'border-muted') }}"
                placeholder="..." {{ $isCorrect !== null ? 'disabled' : '' }} autofocus>
            @else
            <div class="w-[70%] md:w-full py-3 md:py-4 px-4 rounded-xl font-bold text-md md:text-lg border-2 border-muted bg-surface text-body flex items-center justify-center text-center tracking-tight">
                {{ $displayValue }}
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @if($isCorrect === null)
    <button wire:click="checkAnswer"
        class="w-[70%] py-3 md:py-4 bg-primary text-surface uppercase rounded-xl font-bold text-base md:text-lg tracking-[0.2em] shadow-xl transition-all hover:scale-[1.03] active:scale-95">
        Vérifier la grille
    </button>
    @endif
</div>