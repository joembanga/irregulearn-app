<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-lg">
    <div class="flex justify-between mb-4">
        <span class="text-gray-500">Vies : ❤️ {{ auth()->user()->lives }}</span>
        <span class="text-indigo-600 font-bold">XP : {{ auth()->user()->xp_total }}</span>
    </div>

    @if(auth()->user()->lives <= 0) <div class="bg-red-50 p-8 rounded-3xl text-center border-2 border-red-200">
        <span class="text-5xl">😴</span>
        <h3 class="text-xl font-bold text-red-800 mt-4">Plus de vies !</h3>
        <p class="text-red-600 mb-6 text-sm">Prends une pause, elles reviennent toutes les heures.</p>
        <a href="{{ route('shop') }}" class="bg-red-600 text-white px-6 py-3 rounded-xl font-bold">
            Acheter des vies (500 XP)
        </a>
        </div>
        @else
    @endif

    @if($currentExercise)
    <h2 class="text-2xl font-bold mb-6 text-center">
        {{ $currentExercise->question }}
    </h2>

    <div class="space-y-4">
        <input type="text" wire:model="userAnswer" wire:keydown.enter="checkAnswer"
            class="w-full p-4 border-2 rounded-lg @if($isCorrect === true) border-green-500 @elseif($isCorrect === false) border-red-500 @endif"
            placeholder="Tape ta réponse..." @if($isCorrect !==null) disabled @endif>

        @if($isCorrect === null)
        <button wire:click="checkAnswer"
            class="w-full bg-indigo-600 text-white p-4 rounded-lg font-bold hover:bg-indigo-700 transition">
            Vérifier
        </button>
        @else
        <div
            class="p-4 rounded-lg text-center font-bold {{ $isCorrect ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ $feedback }}
        </div>
        <button wire:click="loadNewExercise" class="w-full bg-gray-800 text-white p-4 rounded-lg font-bold mt-4">
            Continuer
        </button>
        @endif
    </div>
    @endif
</div>