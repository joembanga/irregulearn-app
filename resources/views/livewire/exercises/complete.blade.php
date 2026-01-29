<div class="space-y-6 md:space-y-10 text-center">
    <div class="mb-6 md:mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-body uppercase ">{{ __('Complète la suite') }}</h2>
        <p class="text-xs md:text-sm font-bold text-muted tracking-widest mt-2">{{ __('Te rappelles tu de toutes les formes de ce verbe') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <template x-for="(displayValue, label) in (q?.forms || {})" :key="label">
            <div class="flex flex-col gap-3 items-center mb-2">
                <span class="text-[8px] lg:text-xs font-bold uppercase  text-muted text-center" x-text="label.replace('_', ' ')">
                </span>

                <template x-if="label === q.removedForm">
                    <input x-model="userInput" @keydown.enter="checkLocalAnswer()" type="text"
                        class="w-[70%] md:w-full text-center py-3 md:py-4 px-4 border-2 rounded-xl text-md md:text-lg font-bold  bg-app focus:outline-none transition-all duration-500"
                        :class="isCorrect === true ? 'border-success text-success' : (isCorrect === false ? 'border-danger text-danger' : 'border-muted')"
                        placeholder="..." :disabled="isCorrect !== null" autofocus>
                </template>
                <template x-if="label !== q.removedForm">
                    <div class="w-[70%] md:w-full py-3 md:py-4 px-4 rounded-xl font-bold text-md md:text-lg border-2 border-muted bg-surface text-body flex items-center justify-center text-center " x-text="displayValue">
                    </div>
                </template>
            </div>
        </template>
    </div>

    <button x-show="isCorrect === null"
        @click="checkLocalAnswer()"
        class="w-[70%] py-3 md:py-4 bg-primary text-surface uppercase rounded-xl font-bold text-base md:text-lg  shadow-xl transition-all hover:scale-[1.03] active:scale-95">
        {{ __('Vérifier la grille') }}
    </button>
</div>