<div class="grid grid-cols-2 gap-4">
    @foreach($choices as $choice)
    <button
        wire:key="quiz-{{ $currentVerb->id }}-{{ $currentIndex }}" wire:click="checkAnswer('{{ $choice }}')" class="p-6 rounded-2xl font-bold text-lg border-2 transition-all duration-300 hover:scale-105 active:scale-95 {{ $isCorrect === true && strtolower($choice) === strtolower($currentVerb->{$currentTargetForm}) ? 'bg-success border-success text-surface' : ($isCorrect === false && strtolower($choice) === strtolower($currentVerb->{$currentTargetForm}) ? 'bg-success border-success text-surface' : ($isCorrect === false ? 'bg-danger-10 border-danger text-danger opacity-50' : 'bg-surface border-muted text-muted hover:border-primary hover:text-primary')) }}">
        {{ $choice }}
    </button>
    @endforeach
</div>