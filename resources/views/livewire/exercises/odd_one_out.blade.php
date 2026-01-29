<div class="text-center">
    <div class="mb-6 md:mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-body uppercase ">{{ __('Trouve l\'intrus') }}</h2>
        <p class="text-xs md:text-sm font-bold text-muted tracking-widest mt-2">{{ __('Quel verbe régulier s\'est glissé dans cette liste ?') }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <template x-for="(choice, index) in (q?.choices || [])" :key="index">
            <button
                @click="checkLocalAnswer(choice)"
                class="border-muted bg-surface text-body text-center  group p-4 md:p-6 rounded-xl capitalize font-bold text-md md:text-lg border-2 transition-all hover:scale-102 active:scale-95 flex flex-col items-center justify-center gap-1 md:gap-2"
                :class="isCorrect !== null && choice.toLowerCase() === localAnswer.toLowerCase() ? 'border-success text-success' :
                       (isCorrect === false && choice.toLowerCase() === (userInput || '').toLowerCase() ? 'border-danger text-danger' :
                       (isCorrect !== null ? 'bg-surface border-muted text-muted opacity-50' : 'bg-surface border-muted text-body hover:shadow-lg hover:shadow-primary/5'))"
                :disabled="isCorrect !== null">
                <span class="er" x-text="choice"></span>
            </button>
        </template>
    </div>
</div>
