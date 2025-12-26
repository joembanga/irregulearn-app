<div class="max-w-md mx-auto card-surface p-6 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
    <div class="flex justify-between mb-4">
        <span class="text-primary font-bold">XP : {{ auth()->user()->xp_balance }}</span>
    </div>

    @if($currentExercise)
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">{{ $currentExercise->question }}</h2>

    <div class="space-y-4">
        <input type="text" wire:model="userAnswer" wire:keydown.enter="checkAnswer" class="w-full p-4 rounded-lg border-2 focus:ring-2 focus:ring-accent focus:border-accent @if($isCorrect === true) border-success @elseif($isCorrect === false) border-danger @endif" placeholder="Tape ta réponse..." @if($isCorrect !==null) disabled @endif>

        @if($isCorrect === null)
        <button wire:click="checkAnswer" class="w-full bg-primary text-white p-4 rounded-lg font-bold hover:opacity-95 transition">Vérifier</button>
        @else
        <div class="p-4 rounded-lg text-center font-bold {{ $isCorrect ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">{{ $feedback }}</div>
        <button wire:click="getNextExercise" class="w-full bg-accent text-white p-4 rounded-lg font-bold mt-4">Continuer</button>
        @endif
    </div>
    @endif
</div>