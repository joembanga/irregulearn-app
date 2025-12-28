<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            @isset($category)
            <section class="card-surface rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $category->name }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $category->description }}</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('verbslist') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-accent">Voir la liste des
                            verbes</a>
                    </div>
                </div>

                <div class="mt-4">
                    <livewire:quiz-engine :categorySlug="$category->slug" />
                </div>
            </section>
            @else
            <section class="card-surface rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Ton Parcours d'apprentissage
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Apprends à ton rythme — complète les
                            catégories pour gagner des XP et débloquer la suite.</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('verbslist') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-accent">Voir la liste des
                            verbes</a>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($categories as $category)
                        <div
                            class="relative bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700 transition-transform hover:-translate-y-1">
                            <div class="flex items-start">
                                <div @class([ 'flex-shrink-0 w-16 h-16 rounded-xl flex items-center justify-center text-white text-2xl font-bold'
                                    , 'bg-gradient-to-br from-primary to-purple-500 shadow-md'=> !$category->is_locked,
                                    'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300' =>
                                    $category->is_locked
                                    ])>
                                    @if($category->is_locked)
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    @else
                                    <span>🎯</span>
                                    @endif
                                </div>

                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold mb-1 text-gray-900 dark:text-white">
                                        {{ $category->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        {{ $category->description }}</p>

                                    @if(!$category->is_locked)
                                    <div
                                        class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-4 overflow-hidden">
                                        <div class="bg-primary h-2.5 rounded-full transition-all duration-700"
                                            style="width: {{ $category->progress }}%"></div>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <a href="{{ route('learn.category', $category->slug) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-semibold transition-shadow shadow-sm">
                                            Continuer
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        <div class="text-sm text-gray-700 dark:text-gray-300 font-semibold">
                                            {{ $category->progress }}%</div>
                                    </div>
                                    @else
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1">
                                            <div
                                                class="text-xs font-semibold text-orange-500 uppercase tracking-widest">
                                                Verrouillé</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Coût: <span
                                                    class="font-bold">{{ $category->cout }} XP</span></div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button
                                                class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-semibold">Déverrouiller</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endisset
        </div>
    </div>
</x-app-layout>