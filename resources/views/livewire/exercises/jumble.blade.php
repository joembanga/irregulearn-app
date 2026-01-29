<div class="space-y-6 md:space-y-10">
    <!-- Lettres assemblées -->
    <div class="flex flex-wrap justify-center gap-2 md:gap-3 min-h-14 md:min-h-18 p-4 bg-app/50 border-2 border-dashed border-muted rounded-2xl transition-all duration-300"
         :class="isCorrect === true ? 'border-success bg-success/5' : (isCorrect === false ? 'border-danger bg-danger/5' : '')">
        <template x-for="(letter, index) in selectedLetters" :key="'selected-' + index">
            <button 
                @click="unselectLetter(index)"
                :disabled="isCorrect !== null"
                class="w-10 h-10 md:w-14 md:h-14 flex items-center justify-center bg-primary text-surface rounded-xl font-bold text-lg md:text-2xl shadow-lg hover:scale-105 active:scale-95 transition-all transform animate-in zoom-in duration-300">
                <span x-text="letter"></span>
            </button>
        </template>
    </div>

    <!-- Lettres à piocher -->
    <div class="flex flex-wrap justify-center gap-2 md:gap-3">
        <template x-for="(letter, index) in jumbleLetters" :key="'jumble-' + index">
            <button 
                @click="selectLetter(index)"
                :disabled="isCorrect !== null"
                class="w-10 h-10 md:w-14 md:h-14 flex items-center justify-center bg-surface border-2 border-muted hover:border-primary text-body rounded-xl font-bold text-lg md:text-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 active:scale-95 transition-all transform">
                <span x-text="letter"></span>
            </button>
        </template>
    </div>

    <!-- Actions -->
    <div class="flex justify-center" x-show="isCorrect === null">
        <button 
            @click="checkLocalAnswer()"
            :disabled="selectedLetters.length === 0"
            class="px-8 py-3 md:py-4 bg-primary text-surface rounded-xl font-bold text-base md:text-lg uppercase  shadow-xl hover:scale-110 active:scale-95 disabled:opacity-50 disabled:scale-100 transition-all">
            {{ __('Vérifier') }}
        </button>
    </div>
</div>
