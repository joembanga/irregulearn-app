<div class="py-12 max-w-2xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Ton Parcours d'Apprentissage</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Maîtrise chaque catégorie pour débloquer la suivante.</p>
    </div>

    <div class="relative">
        <div
            class="absolute left-1/2 transform -translate-x-1/2 h-full w-1.5 bg-gray-200 dark:bg-gray-700 rounded-full">
        </div>

        <div class="space-y-16">
            @foreach($categories as $category)
            <div class="relative z-10 flex flex-col items-center">

                <div @class([ 'group relative w-24 h-24 rounded-full flex items-center justify-center border-8 transition-all duration-300 shadow-xl'
                    , 'bg-indigo-600 border-indigo-100 dark:border-indigo-900 text-white hover:scale-110'=>
                    !$category->is_locked,
                    'bg-gray-300 border-gray-100 dark:bg-gray-800 dark:border-gray-900 text-gray-500' =>
                    $category->is_locked
                    ])>
                    @if($category->is_locked)
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    @else
                    <a href="{{ route('learn.category', $category->slug) }}"
                        class="absolute inset-0 flex items-center justify-center">
                        <span class="text-3xl">🎯</span>
                    </a>
                    <div
                        class="absolute -top-2 -right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full border-2 border-white dark:border-gray-900">
                        {{ $category->progress }}%
                    </div>
                    @endif
                </div>

                <div
                    class="mt-6 text-center bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 w-full max-w-sm">
                    <h3 @class([ 'text-xl font-bold mb-1' , 'text-gray-900 dark:text-white'=> !$category->is_locked,
                        'text-gray-400' => $category->is_locked
                        ])>{{ $category->name }}</h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $category->description }}</p>

                    @if(!$category->is_locked)
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                        <div class="bg-indigo-500 h-2.5 rounded-full transition-all duration-700"
                            style="width: {{ $category->progress }}%"></div>
                    </div>
                    <a href="{{ route('learn.category', $category->slug) }}"
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition shadow-md">
                        Continuer
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @session('success')
                    <div>
                        {{ session('success') }}
                    </div>
                    @endsession
                    @else
                    <div>
                        <div class="text-xs font-semibold text-orange-500 uppercase tracking-widest">Verrouillé</div>
                        <button wire:click="unlockCategory({{ $category->id }}, {{ $category->cout }})"
                            class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition shadow-md">
                            {{ __('Deverouiller ? ') }}
                        </button>
                        <div>
                            {{ $category->cout }} XP
                        </div>
                        @session('error')
                            <div>
                                {{ session('error') }}
                            </div>
                        @endsession
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>