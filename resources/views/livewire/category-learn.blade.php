<div class="py-12 max-w-xl mx-auto px-4">
    @if(!$finished)
    <div
        class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 border border-gray-100 dark:border-gray-700 relative overflow-hidden">

        <div class="absolute top-0 left-0 h-1 bg-indigo-600 transition-all duration-500"
            style="width: {{ (($currentIndex) / count($verbs)) * 100 }}%"></div>

        <div class="flex justify-between items-center mb-8">
            <span class="text-xs font-bold tracking-widest text-indigo-500 uppercase">{{ $category->name }}</span>
            <span class="text-xs font-bold text-gray-400">VERBE {{ $currentIndex + 1 }}/{{ count($verbs) }}</span>
        </div>

        <div class="text-center mb-10">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2 uppercase">Conjugue au Prétérit (Past Simple)</p>
            {{-- <h2 class="text-5xl font-black text-gray-900 dark:text-white mb-2 tracking-tight">
                {{ $currentVerb->infinitive }}
            </h2> --}}
            <h2
                class="text-5xl font-black text-gray-900 dark:text-white mb-2 tracking-tight flex items-center justify-center gap-4">
                {{ $currentVerb->infinitive }}
            
                <button
                    onclick="let u = new SpeechSynthesisUtterance('{{ $currentVerb->infinitive }}'); u.lang='en-GB'; speechSynthesis.speak(u);"
                    class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-indigo-100 dark:hover:bg-indigo-900 text-gray-500 hover:text-indigo-600 transition shadow-sm"
                    title="Écouter la prononciation">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                        </path>
                    </svg>
                </button>
            </h2>
            <p class="text-indigo-500 font-medium text-lg">{{ $currentVerb->translation }}</p>
        </div>

        <div class="min-h-[200px] flex flex-col justify-center">

            {{-- TYPE 1 : INPUT CLASSIQUE --}}
            @if($currentType === 'input')
            <div class="space-y-4">
                <input wire:model.defer="answer" wire:keydown.enter="checkAnswer" type="text"
                    class="w-full text-center p-4 border-2 rounded-2xl text-2xl font-bold bg-gray-50 dark:bg-gray-900 dark:text-white focus:outline-none focus:ring-0 transition-colors
                            {{ $isCorrect === true ? 'border-green-500 bg-green-50 text-green-700' : ($isCorrect === false ? 'border-red-500 bg-red-50 text-red-700' : 'border-gray-200 dark:border-gray-700') }}"
                    placeholder="Tape ta réponse..." {{ $isCorrect !== null ? 'disabled' : '' }} autofocus>
                @if($isCorrect === null)
                <button wire:click="checkAnswer"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-lg shadow-lg transition transform active:scale-95">
                    Valider
                </button>
                @endif
            </div>

            {{-- TYPE 2 : QUIZ (QCM) --}}
            @elseif($currentType === 'quiz')
            <div class="grid grid-cols-2 gap-4">
                @foreach($choices as $choice)
                <button wire:click="checkAnswer('{{ $choice }}')" @disabled($isCorrect !==null) class="p-6 rounded-2xl font-bold text-lg border-2 transition-all duration-200 transform hover:scale-105
                                {{ 
                                    $isCorrect === true && strtolower($choice) == strtolower($currentVerb->past_simple) ? 'bg-green-500 border-green-500 text-white shadow-green-200' : 
                                    ($isCorrect === false && strtolower($choice) == strtolower($currentVerb->past_simple) ? 'bg-green-500 border-green-500 text-white' : 
                                    ($isCorrect === false ? 'bg-red-100 border-red-100 text-red-400 opacity-50' : 
                                    'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-indigo-500 hover:text-indigo-600 shadow-sm'))
                                }}">
                    {{ $choice }}
                </button>
                @endforeach
            </div>

            {{-- TYPE 3 : JUMBLE (Méli-mélo) --}}
            @elseif($currentType === 'jumble')
            <div class="text-center space-y-8">
                <div class="flex flex-wrap justify-center gap-2 min-h-[60px]">
                    @foreach($selectedLetters as $index => $letter)
                    <button wire:click="unselectLetter({{ $index }})"
                        class="w-12 h-12 rounded-xl bg-indigo-600 text-white font-bold text-xl shadow-lg transform hover:-translate-y-1 transition">
                        {{ $letter }}
                    </button>
                    @endforeach
                    @if(count($selectedLetters) === 0)
                    <div class="w-full text-gray-400 italic text-sm py-4">Clique sur les lettres ci-dessous</div>
                    @endif
                </div>

                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($jumbledLetters as $index => $letter)
                    <button wire:click="selectLetter({{ $index }})"
                        class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 border-b-4 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-bold text-xl hover:bg-gray-200 active:border-b-0 active:translate-y-1 transition">
                        {{ $letter }}
                    </button>
                    @endforeach
                </div>

                @if($isCorrect === null && count($selectedLetters) > 0)
                <button wire:click="checkAnswer"
                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full font-bold shadow-lg transition">
                    Vérifier
                </button>
                @endif
            </div>
            @endif

        </div>

        @if($isCorrect !== null)
        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 animate-fade-in-up">
            @if($isCorrect)
            <div class="flex items-center text-green-500 font-bold mb-4">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Bonne réponse ! (+10 XP)
            </div>
            @else
            <div class="flex flex-col text-red-500 font-bold mb-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    Faux !
                </div>
                <span class="text-gray-600 dark:text-gray-400 text-sm mt-1">La réponse était : <span
                        class="text-indigo-500 font-bold">{{ $currentVerb->past_simple }}</span></span>
            </div>
            @endif

            <button wire:click="nextVerb"
                class="w-full py-4 bg-gray-900 dark:bg-white dark:text-gray-900 text-white rounded-2xl font-bold text-lg hover:opacity-90 transition shadow-lg">
                Question Suivante →
            </button>
        </div>
        @endif

    </div>
    @else
    <div
        class="text-center bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-xl border border-gray-100 dark:border-gray-700">
        <div class="text-7xl mb-6">🏆</div>
        <h2 class="text-3xl font-black dark:text-white mb-4">Session Terminée !</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">Tu as gagné <span class="text-indigo-500 font-bold">+50
                XP</span> bonus.</p>
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
            Retour au parcours
        </a>
    </div>
    @endif
</div>