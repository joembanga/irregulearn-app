<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            @isset($category)
            <section class="card-surface rounded-2xl p-6 shadow-lg border border-muted">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-extrabold text-body">{{ $category->name }}</h1>
                        <p class="text-sm text-muted">{{ $category->description }}</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('verbs.index') }}" class="text-sm text-muted hover:text-accent">Voir la liste
                            des verbes</a>
                    </div>
                </div>
            </section>
            @else
            <section class="card-surface rounded-2xl p-6 shadow-lg border border-muted">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-extrabold text-body">Ton Parcours d'apprentissage</h1>
                        <p class="text-sm text-muted">Apprends à ton rythme — complète les catégories pour gagner des XP
                            et débloquer la suite.</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('verbs.index') }}" class="text-sm text-muted hover:text-accent">Voir la liste
                            des verbes</a>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="mt-8 grid gap-6 grid-cols-1">
                        @foreach ($categories as $category)
                        <div
                            class="relative rounded-2xl p-5 transition-transform hover:-translate-y-1 flex flex-col h-full bg-white/5 backdrop-blur-md border border-white/10 shadow-lg">
                            <div class="flex items-start flex-1 gap-4">
                                <div class="flex-shrink-0 w-20 h-20 rounded-2xl flex items-center justify-center text-surface text-3xl font-extrabold shadow-md"
                                    style="background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(124,58,237,0.12));">
                                    @if ($category->is_locked)
                                    <div
                                        class="flex items-center justify-center w-12 h-12 rounded-full bg-black/40 text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    @else
                                    <div class="text-2xl">🎯</div>
                                    @endif
                                </div>

                                <div class="flex-1 flex flex-col">
                                    <h3 class="text-lg font-extrabold mb-1 text-body tracking-tight">
                                        {{ $category->name }}</h3>
                                    <p class="text-sm text-muted mb-3">{{ $category->description }}</p>

                                    @if (!$category->is_locked)
                                    <div class="w-full bg-white/6 rounded-full h-2.5 mb-4 overflow-hidden">
                                        <div class="bg-gradient-to-r from-primary to-purple-500 h-2.5 rounded-full transition-all duration-700"
                                            style="width: {{ $category->progress }}%"></div>
                                    </div>

                                    <div class="flex items-center justify-between gap-3 mt-auto">
                                        <a href="{{ route('learn.category', $category->slug) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-surface rounded-lg font-semibold shadow-sm">
                                            Continuer
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        <div class="text-sm font-bold text-body">{{ $category->progress }}%</div>
                                    </div>
                                    @else
                                    <div class="flex items-center gap-3 mt-auto">
                                        <div class="flex-1">
                                            <div class="text-xs font-semibold text-warning uppercase tracking-widest">
                                                Verrouillé</div>
                                            <div class="text-sm text-muted">Coût: <span
                                                    class="font-bold">{{ $category->cout }} XP</span></div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button
                                                class="px-4 py-2 bg-primary text-surface rounded-lg font-semibold shadow-sm">Déverrouiller</button>
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