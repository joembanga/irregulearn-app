<div class="bg-app py-1 flex flex-col items-center relative overflow-hidden"
     x-data="{ 
         timeRemaining: {{ $mode === 'timed' ? 150 : 0 }},
         timerInterval: null,
         questions: @js($questionsData),
         currentIndex: @entangle('currentIndex'),
         isCorrect: @entangle('isCorrect'),
         userInput: @entangle('userInput'),
         goodAnswers: @entangle('goodAnswers'),
         
         // Question data
         q: null,
         localAnswer: '',
         jumbleLetters: [],
         selectedLetters: [],
         
         init() {
             this.loadQuestion();
             this.startTimer();
         },
         loadQuestion() {
             this.q = this.questions[this.currentIndex];
             this.isCorrect = null;
             this.userInput = '';
             this.selectedLetters = [];
             this.jumbleLetters = this.q.jumbledLetters ? [...this.q.jumbledLetters] : [];
             this.localAnswer = this.q.answer;
         },
         selectLetter(index) {
             if (this.isCorrect !== null) return;
             this.selectedLetters.push(this.jumbleLetters[index]);
             this.jumbleLetters.splice(index, 1);
         },
         unselectLetter(index) {
             if (this.isCorrect !== null) return;
             this.jumbleLetters.push(this.selectedLetters[index]);
             this.selectedLetters.splice(index, 1);
         },
         checkLocalAnswer(submitted = null) {
             let attempt = submitted || this.userInput;
             if (this.q.type === 'jumble') attempt = this.selectedLetters.join('');

             attempt = attempt.trim().toLowerCase();
             let possible = this.localAnswer.toLowerCase().split('/');

             let success = possible.includes(attempt);

             // Instant feedback
             this.isCorrect = success;
             if (!success) {
                 this.userInput = this.localAnswer;
             }

             // Background sync to server
             $wire.recordResult(success, this.q.id);
         },
         next() {
             if (this.currentIndex < this.questions.length - 1) {
                 this.currentIndex++;
                 this.loadQuestion();
                 // Background sync next question on server for persistence
                 // (optional but helps if user refreshes)
             } else {
                 $wire.finishSession();
             }
         },
         startTimer() {
            if (this.timeRemaining > 0) {
                if (this.timerInterval) clearInterval(this.timerInterval); // Sécurité
                this.timerInterval = setInterval(() => {
                    if (this.timeRemaining <= 0) {
                        clearInterval(this.timerInterval);
                        $wire.call('finishTimedSession');
                        return;
                    }
                    this.timeRemaining--;
                }, 1000);
            }
    }
     }"
     x-init="startTimer()">
    
    <!-- Background Decoration - Mode Specific Colors -->
    @php
        $bgColors = [
            'daily' => ['bg-purple-500/5', 'bg-indigo-500/5'],
            'timed' => ['bg-orange-500/5', 'bg-red-500/5'],
            'revision' => ['bg-emerald-500/5', 'bg-teal-500/5'],
            'custom' => ['bg-pink-500/5', 'bg-rose-500/5'],
            'favorites' => ['bg-yellow-500/5', 'bg-amber-500/5'],
            'category' => ['bg-primary/5', 'bg-indigo-500/5'],
        ];
        $colors = $bgColors[$mode] ?? $bgColors['category'];
    @endphp

    <div class="w-full max-w-2xl px-4 md:px-6 mb-2">
        @php
            $modeConfig = [
                'daily' => ['icon' => 'calendar-fold', 'title' => __('Pratique Quotidienne'), 'bg-color' => 'bg-indigo-600'], // from-purple-500
                'timed' => ['icon' => 'timer', 'title' => __('Course Contre la Montre'), 'bg-color' => 'bg-orange-500'],
                'revision' => ['icon' => 'brain', 'title' => __('Mode Révision'), 'bg-color' => 'bg-emerald-500'], //to-teal-600
                'custom' => ['icon' => 'goal', 'title' => __('Pratique Ciblée'), 'bg-color' => 'bg-rose-600'], //rose-600
                'favorites' => ['icon' => 'star', 'title' => __('Verbes Favoris'), 'bg-color' => 'bg-yellow-500'], //amber-600
                'category' => ['icon' => 'library-big', 'title' => $category?->name ?? __('Catégorie'), 'bg-color' => 'bg-blue-500'], //to-cyan-600
            ];
            $config = $modeConfig[$mode] ?? $modeConfig['category'];
        @endphp
        @if (!$finished)
        <a href="{{ route('learn.index') }}" wire:navigate
            class="inline-flex items-center gap-2 text-muted hover:text-primary hover:underline transition-colors mb-4">
            <span>
                <x-lucide-move-left class="size-3 inline stroke-3" />
            </span>
            <span class="">{{ __('Retour aux modes') }}</span>
        </a>

        <!-- Mode-Specific Header -->
        <div class="text-center flex flex-col items-center justify-center mb-2 md:mb-4 shrink-0">

            <div class="inline-flex items-center gap-2 px-6 py-4 rounded-xl {{ $config['bg-color'] }} text-white shadow-lg mb-4">
                <x-icon name="lucide-{{ $config['icon'] }}" class="size-6 shrink-0" />
                <h1 class="font-bold text-xl uppercase tracking-wider">{{ $config['title'] }}</h1>
            </div>

            @if($mode === 'timed')
                <!-- Timer Display -->
                <div class="mt-6 inline-flex items-center gap-4 px-8 py-4 bg-surface border-2 border-orange-500/30 rounded-2xl shadow-xl">
                    <div class="flex flex-col items-center">
                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider mb-1">{{ __('Temps Restant') }}</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-bold text-body tabular-nums" x-text="Math.max(0, Math.floor(timeRemaining / 60))">2</span>
                            <span class="text-2xl font-bold text-muted">:</span>
                            <span class="text-4xl font-bold text-body tabular-nums" x-text="(timeRemaining % 60).toString().padStart(2, '0')">00</span>
                        </div>
                    </div>
                    <div class="w-px h-12 bg-muted/30"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider mb-1">{{ __('Score') }}</span>
                        <span class="text-3xl font-bold text-primary">{{ $sessionXp }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Progress visualization -->
        <div class="mb-6 md:mb-8 space-y-2 shrink-0">
            <div class="flex items-center justify-end px-2">
                <span class="text-[10px] font-bold text-primary uppercase ">
                    <span x-text="currentIndex + 1"></span> / <span x-text="questions.length"></span>
                </span>
            </div>
            <div class="h-2 w-full bg-surface rounded-full shadow-inner border border-muted">
                <div class="h-full {{ $config['bg-color'] }} rounded-full transition-all duration-700 ease-out shadow-lg"
                    :style="'width: ' + ((currentIndex + 1) / questions.length * 100) + '%'">
                </div>
            </div>
        </div>

        <div class="card-surface rounded-xl p-5 md:p-6 border-2 border-muted relative group transition-all duration-500 flex-1 flex flex-col justify-center min-h-0"
             :class="isCorrect === true ? 'border-success' : (isCorrect === false ? 'border-danger' : '')">

            <div x-show="q?.type === 'odd_one_out'" class="flex-1 flex flex-col justify-center">
                @include('livewire.exercises.odd_one_out')
            </div>
            <div x-show="q?.type === 'complete'" class="flex-1 flex flex-col justify-center">
                @include('livewire.exercises.complete')
            </div>
            <div x-show="q?.type === 'sentence'" class="flex-1 flex flex-col justify-center">
                <div class="text-center mb-4 md:mb-6 shrink-0">
                    <p class="text-xs md:text-sm font-bold text-muted tracking-widest mb-2">
                        {{ __('Conjugue de la bonne façon le verbe') }}
                    </p>
                    <h2 class="text-2xl md:text-3xl font-bold text-body mb-2 tracking-normal">
                        To <span x-text="q?.infinitive"></span>
                    </h2>
                </div>
                @include('livewire.exercises.sentence')
            </div>
            <div x-show="['input', 'quiz', 'jumble'].includes(q?.type)" class="flex-1 flex flex-col justify-center">
                <div class="text-center mb-4 md:mb-6 shrink-0">
                    <p class="text-xs md:text-sm font-bold text-muted tracking-widest mb-2">
                        <strong class="capitalize mt-2" x-text="(q?.targetForm || '').replace('_', ' ')"></strong> de
                    </p>
                    <h2 class="text-2xl md:text-3xl font-bold text-body mb-2 er flex items-center justify-center gap-4">
                        To <span x-text="q?.infinitive"></span>
                    </h2>
                </div>

                <div class="flex-1 flex flex-col justify-center min-h-0 overflow-y-auto no-scrollbar">
                    <div x-show="q?.type === 'input'">
                        @include('livewire.exercises.input')
                    </div>
                    <div x-show="q?.type === 'quiz'">
                        @include('livewire.exercises.quiz')
                    </div>
                    <div x-show="q?.type === 'jumble'">
                        @include('livewire.exercises.jumble')
                    </div>
                </div>
            </div>

            <div x-show="isCorrect !== null" class="flex items-center justify-center mt-5 md:mt-8">
                <button @click="next()"
                    class="w-[70%] py-3 md:py-4 bg-primary text-surface rounded-xl font-bold text-base md:text-lg uppercase  transition-all hover:scale-[1.02] active:scale-95 shadow-xl">
                    {{ __('Continuer') }} →
                </button>
            </div>
        </div>
        @else
        <!-- Success/Finished State -->
        <div class="mt-10 text-center bg-surface rounded-xl p-6 md:p-10 shadow-2xl border border-muted relative overflow-hidden group">

            <div class="relative z-10">
                <div class="mb-6 animate-bounce transition-transform duration-500">
                    @if($mode === 'timed')
                        <x-heroicon-o-bolt class="size-20 fill-amber-400 stroke-amber-400 inline" />
                    @elseif($mode === 'revision')
                        <x-lucide-graduation-cap class="size-20 text-purple-900 fill-purple-600 inline" />
                    @elseif($mode === 'favorites')
                        <x-lucide-star class="size-20 fill-amber-400 stroke-amber-400 inline" />
                    @else
                        <x-lucide-circle-check-big class="size-20 fill-none stroke-success inline" />
                    @endif
                </div>
                
                <h2 class="text-4xl md:text-5xl font-bold text-body mb-4 uppercase er">
                    @if($mode === 'timed')
                        {{ __('Temps écoulé !') }}
                    @else
                        {{ __('Bien joué !') }}
                    @endif
                </h2>
                
                <p class="text-muted mb-12 text-lg font-medium leading-relaxed">
                    @if($mode === 'timed')
                        {{ __('Challenge terminé !') }} <br>
                        {{ __('Tu as répondu à') }} <span class="text-primary font-bold">{{ $goodAnswers }}</span> {{ __('questions correctement.') }}<br>
                    @elseif($mode === 'revision')
                        {{ __('Excellente révision !') }} <br>
                        {{ __('Tu continues de renforcer tes connaissances.') }}<br>
                    @else
                        {{ __('Session terminée avec brio.') }} <br>
                    @endif
                    {{ __('Tu as récolté un bonus de') }} <span class="text-primary font-bold ml-1">{{ $finished_reward }} XP</span>.
                </p>

                <div class="grid grid-cols-3 gap-4 mb-8 max-w-md mx-auto">
                    <div class="bg-app rounded-2xl p-4 border border-muted">
                        <div class="text-3xl font-bold text-primary">{{ count($verbIds) }}</div>
                        <div class="text-xs text-muted font-bold uppercase">{{ __('Questions') }}</div>
                    </div>
                    <div class="bg-app rounded-2xl p-4 border border-muted">
                        <div class="text-3xl font-bold text-success">{{ $goodAnswers }}</div>
                        <div class="text-xs text-muted font-bold uppercase">{{ __('Correctes') }}</div>
                    </div>
                    <div class="bg-app rounded-2xl p-4 border border-muted">
                        <div class="text-3xl font-bold text-body">{{ $finished_reward }}</div>
                        <div class="text-xs text-muted font-bold uppercase">{{ __('XP Gagnés') }}</div>
                    </div>
                </div>
                
                <a href="{{ route('learn.index') }}" wire:navigate
                    class="inline-flex items-center px-12 py-5 bg-primary text-surface rounded-4xl font-bold text-base uppercase  transition-all hover:scale-110 active:scale-95 shadow-2xl shadow-primary/30">
                    {{ __('RETOUR AUX MODES') }}
                </a>
            </div>
        </div>
        @endif
    </div>
</div>