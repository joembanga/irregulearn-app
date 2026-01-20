<x-app-layout>
    <div class="py-2 bg-app min-h-screen max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Hero Header -->
        <div class="mb-10 text-left">
            <h1 class="text-3xl md:text-4xl font-bold text-body tracking-tight">
                {{ __('Centre d\'Entraînement') }}
            </h1>
            <p class="text-muted font-medium mt-2 text-lg">
                {{ __('Choisis ton mode de pratique et améliore ta maîtrise des verbes irréguliers') }}
            </p>
        </div>
            <!-- Practice Modes Grid -->
            <div class="grid md:grid-cols-2 gap-8 mb-12">

                <!-- Quick Practice / Daily -->
                <div class="group relative bg-linear-to-br from-purple-500 to-indigo-600 rounded-xl p-8 shadow-2xl overflow-hidden transform transition-all hover:scale-[1.02] hover:shadow-3xl">
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <x-lucide-calendar-fold class="size-13 text-white" />
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold text-white uppercase tracking-wider">
                                {{ __('Recommandé') }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">{{ __('Pratique Quotidienne') }}</h3>
                        <p class="text-white/90 mb-6 leading-relaxed">
                            {{ __('20 verbes spécialement sélectionnés pour toi aujourd\'hui. Parfait pour maintenir ta progression !') }}
                        </p>
                        <a href="{{ route('learn.session', ['mode' => 'daily']) }}" wire:navigate
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-purple-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all group">
                            <span>{{ __('Commencer') }}</span>
                            <span class="transform group-hover:translate-x-1 transition-transform">
                                <x-lucide-move-right class="size-5 fill-current" />
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Timed Challenge -->
                <div class="group relative bg-linear-to-br from-orange-500 to-red-600 rounded-xl p-8 shadow-2xl overflow-hidden transform transition-all hover:scale-[1.02] hover:shadow-3xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <x-lucide-timer class="size-13 text-white" />
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold text-white uppercase tracking-wider">
                                {{ __('Défi') }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">{{ __('Course Contre la Montre') }}</h3>
                        <p class="text-white/90 mb-6 leading-relaxed">
                            {{ __('Teste ta rapidité ! Réponds à un maximum de questions en 2 minutes. Gagne des bonus !') }}
                        </p>
                        <a href="{{ route('learn.session', ['mode' => 'timed']) }}" wire:navigate
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-orange-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all group">
                            <span>{{ __('Lancer le Défi') }}</span>
                            <span class="transform group-hover:translate-x-1 transition-transform">
                                <x-lucide-flame class="size-5 fill-current" />
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Revision Mode -->
                <div class="group relative bg-linear-to-br from-emerald-500 to-teal-600 rounded-xl p-8 shadow-2xl overflow-hidden transform transition-all hover:scale-[1.02] hover:shadow-3xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <x-lucide-brain class="size-13 text-white" />
                            @if(auth()->user()->learnedVerbs()->count() > 0)
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold text-white uppercase tracking-wider">
                                    {{ auth()->user()->learnedVerbs()->count() }} {{ __('verbes') }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">{{ __('Mode Révision') }}</h3>
                        <p class="text-white/90 mb-6 leading-relaxed">
                            {{ __('Révise tous les verbes que tu as déjà appris. La répétition est la clé du succès !') }}
                        </p>
                        @if(auth()->user()->learnedVerbs()->count() > 0)
                            <a href="{{ route('learn.session', ['mode' => 'revision']) }}" wire:navigate
                               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-emerald-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all group">
                                <span>{{ __('Réviser') }}</span>
                                <span class="transform group-hover:translate-x-1 transition-transform">
                                    <x-heroicon-o-book-open class="size-5" />
                                </span>
                            </a>
                        @else
                            <div class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-xl font-bold cursor-not-allowed">
                                <span>{{ __('Apprends d\'abord des verbes') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Custom Practice -->
                <div class="group relative bg-linear-to-br from-pink-500 to-rose-600 rounded-xl p-8 shadow-2xl overflow-hidden transform transition-all hover:scale-[1.02] hover:shadow-3xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <x-lucide-goal class="size-13 text-white" />
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold text-white uppercase tracking-wider">
                                {{ __('Personnalisé') }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">{{ __('Pratique Ciblée') }}</h3>
                        <p class="text-white/90 mb-6 leading-relaxed">
                            {{ __('Choisis exactement les verbes que tu veux pratiquer. Crée ta propre session !') }}
                        </p>
                        <a href="{{ route('learn.custom') }}" wire:navigate
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-pink-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all group">
                            <span>{{ __('Créer une Session') }}</span>
                            <span class="transform group-hover:translate-x-1 transition-transform">
                                <x-lucide-list-checks class="size-5" />
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-body">{{ __('Apprendre par Catégories') }}</h2>
                    <span class="text-sm text-muted font-bold">{{ $categories->count() }} {{ __('catégories') }}</span>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($categories as $index => $category)
                    @php
                        $colors = [
                            ['from-blue-500', 'to-cyan-500', 'text-blue-600'],
                            ['from-purple-500', 'to-pink-500', 'text-purple-600'],
                            ['from-amber-500', 'to-orange-500', 'text-amber-600'],
                            ['from-green-500', 'to-emerald-500', 'text-green-600'],
                            ['from-red-500', 'to-rose-500', 'text-red-600'],
                            ['from-indigo-500', 'to-violet-500', 'text-indigo-600'],
                        ];
                        $theme = $colors[$index % count($colors)];
                        $isLocked = $category->is_locked;
                    @endphp

                    <div class="group relative bg-surface rounded-2xl border border-muted overflow-hidden transition-all hover:shadow-xl {{ !$isLocked ? 'hover:border-primary/30' : 'opacity-70' }}">
                        @if(!$isLocked)
                            <div class="absolute top-0 left-0 right-0 h-2 bg-linear-to-r {{ $theme[0] }} {{ $theme[1] }}"></div>
                        @else
                            <div class="absolute top-0 left-0 right-0 h-2 bg-linear-to-r from-gray-400 to-gray-500"></div>
                        @endif

                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-body mb-2 flex items-center gap-2">
                                        @if($isLocked)
                                            <span class="text-2xl">🔒</span>
                                        @else
                                            <span class="text-2xl">{{ ['📘', '📕', '📗', '📙', '📔', '📓'][$index % 6] }}</span>
                                        @endif
                                        {{ $category->name }}
                                    </h3>
                                    <p class="text-sm text-muted line-clamp-2">{{ $category->description }}</p>
                                </div>
                            </div>

                            @if(!$isLocked)
                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-bold text-muted uppercase">{{ __('Progression') }}</span>
                                        <span class="text-sm font-bold {{ $theme[2] }}">{{ $category->progress }}%</span>
                                    </div>
                                    <div class="relative w-full h-3 bg-muted/20 rounded-full overflow-hidden">
                                        <div class="absolute top-0 left-0 h-full bg-linear-to-r {{ $theme[0] }} {{ $theme[1] }} transition-all duration-500"
                                             style="width: {{ $category->progress }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('learn.session', ['mode' => 'category', 'name' => $category->slug]) }}" wire:navigate
                                   class="block w-full text-center px-4 py-3 bg-black text-white hover:{{ $theme[2] }} rounded-xl hover:scale-[1.02] font-bold transition-all">
                                    {{ $category->progress == 100 ? __('Rejouer') : __('Commencer') }} 
                                    <span class="transform group-hover:translate-x-1 transition-transform">
                                        <x-lucide-move-right class="size-4 fill-current inline" />
                                    </span>
                                </a>
                            @else
                                <div class="bg-muted/10 rounded-xl p-4 border border-dashed border-muted/30 text-center">
                                    <p class="text-xs font-bold text-muted">
                                        🔒 {{ __('Complète 80% du niveau précédent') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Favorites Section -->
            @if(auth()->user()->favorites()->count() > 0)
            <div class="mt-8">
                <div class="bg-linear-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-3xl p-8 border border-yellow-200 dark:border-yellow-800">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex-1 text-center md:text-left">
                            <div class="text-4xl mb-3">
                                <x-lucide-star class="size-9 md:size-10 fill-yellow-500 text-yellow-500" />
                            </div>
                            <h3 class="text-2xl font-bold text-body mb-2">{{ __('Pratique tes Favoris') }}</h3>
                            <p class="text-muted font-medium">
                                {{ __('Tu as') }} {{ auth()->user()->favorites()->count() }} {{ __('verbes dans tes favoris') }}
                            </p>
                        </div>
                        <a href="{{ route('learn.session', ['mode' => 'favorites']) }}" wire:navigate
                           class="inline-flex items-center gap-2 px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                            <span>{{ __('Pratiquer') }}</span>
                            <span class="transform group-hover:translate-x-1 transition-transform">
                                <x-lucide-star class="size-5" />
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endif
    </div>
</x-app-layout>
