<div class="space-y-4 md:space-y-6 flex flex-col items-center justify-center">
    <input x-model="userInput" @keydown.enter="checkLocalAnswer()" type="text"
            class="w-full text-center py-2 md:py-4 px-4 bg-app border-2 rounded-xl text-lg md:text-xl font-bold tracking-widest focus:outline-none focus:ring-0 transition-all duration-500"
            :class="isCorrect === true ? 'border-success text-success' : (isCorrect === false ? 'border-danger text-danger' : 'border-muted focus:border-primary')"
            placeholder="..."
            :disabled="isCorrect !== null"
            autofocus>
    
    <button x-show="isCorrect === null"
        @click="checkLocalAnswer()"
        class="w-[70%] py-3 md:py-4 bg-primary text-surface rounded-xl font-bold text-base md:text-lg uppercase  transition-all hover:scale-110 active:scale-95 shadow-xl">
        {{ __('Valider') }}
    </button>
</div>
