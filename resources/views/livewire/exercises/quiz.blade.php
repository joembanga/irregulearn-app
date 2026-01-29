<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 px-3">
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
