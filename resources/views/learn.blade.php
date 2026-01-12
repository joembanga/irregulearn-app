<x-app-layout>
    <div class="py-12 bg-app min-h-screen relative overflow-hidden">
        <!-- Decorational blobs -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary/10 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 relative z-10">
            @isset($category)
            <section class="mb-8 transform transition-all hover:scale-[1.01]">
                <div class="bg-surface/80 backdrop-blur-xl rounded-[2rem] p-8 shadow-2xl border-4 border-white/20 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-2xl -mr-10 -mt-10 transition-transform group-hover:scale-150"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="text-6xl mb-4 animate-bounce">🌟</div>
                        <h1 class="text-4xl font-black text-body mb-2 tracking-tight">{{ $category->name }}</h1>
                        <p class="text-lg text-muted font-medium max-w-lg mx-auto">{{ $category->description }}</p>
                        
                        <div class="mt-8">
                            <a href="{{ route('verbs.index') }}" wire:navigate
                                class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary rounded-xl font-black shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                                <span>📚 Voir tout le glossaire</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            @else
            <!-- Hero Header -->
            <div class="text-center mb-12">
                <div class="inline-block relative">
                    <span class="absolute -top-6 -right-6 text-4xl animate-pulse">🚀</span>
                    <h1 class="text-4xl md:text-5xl font-black text-body tracking-tight mb-3">
                        Ton Aventure
                    </h1>
                </div>
                <p class="text-xl text-muted font-medium max-w-xl mx-auto">
                    Chaque catégorie est un nouveau monde. Complète-les pour devenir un <span class="text-primary font-black">Maître des Verbes</span> !
                </p>
            </div>

            <div class="space-y-6">
                @foreach ($categories as $index => $category)
                @php
                    $colors = [
                        ['from-pink-500', 'to-rose-500', 'ring-pink-200', 'bg-pink-50'],
                        ['from-purple-500', 'to-indigo-500', 'ring-purple-200', 'bg-purple-50'],
                        ['from-cyan-400', 'to-blue-500', 'ring-cyan-200', 'bg-cyan-50'],
                        ['from-amber-400', 'to-orange-500', 'ring-amber-200', 'bg-amber-50']
                    ];
                    $theme = $colors[$index % count($colors)];
                    $isLocked = $category->is_locked;
                    $rotation = $index % 2 == 0 ? 'hover:rotate-1' : 'hover:-rotate-1';
                @endphp

                <div class="group relative transform transition-all duration-300 {{ !$isLocked ? 'hover:scale-[1.02] ' . $rotation : 'opacity-80 grayscale-[0.5]' }}">
                    <div class="absolute inset-0 bg-gradient-to-r {{ $theme[0] }} {{ $theme[1] }} rounded-[2.5rem] transform translate-y-2 translate-x-0 transition-transform group-hover:translate-y-3 opacity-20"></div>
                    
                    <div class="relative bg-surface rounded-[2rem] p-6 border-2 {{ !$isLocked ? 'border-transparent ring-4 ' . $theme[2] : 'border-muted border-dashed' }} shadow-xl overflow-hidden flex flex-col md:flex-row items-center gap-6">
                        
                        <!-- Icon Box -->
                        <div class="flex-shrink-0 w-24 h-24 rounded-2xl flex items-center justify-center text-5xl shadow-inner relative overflow-hidden bg-gradient-to-br {{ $theme[0] }} {{ $theme[1] }}">
                            <div class="absolute inset-0 bg-white/20"></div>
                            @if ($isLocked)
                                <div class="relative z-10 animate-pulse">🔒</div>
                            @else
                                <div class="relative z-10 transform group-hover:scale-125 transition-transform duration-500">
                                    {{ ['⚡', '🔥', '💎', '🌈', '🏆'][$index % 5] }}
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 text-center md:text-left w-full">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-2">
                                <h3 class="text-2xl font-black text-body tracking-tight">
                                    {{ $category->name }}
                                </h3>
                                @if(!$isLocked)
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-black/5 text-muted mt-2 md:mt-0">
                                        Niveau {{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-muted font-medium mb-4 leading-relaxed line-clamp-2">
                                {{ $category->description }}
                            </p>

                            @if (!$isLocked)
                            <div class="relative w-full h-5 bg-app rounded-full overflow-hidden shadow-inner border border-black/5">
                                <div class="absolute top-0 left-0 h-full bg-gradient-to-r {{ $theme[0] }} {{ $theme[1] }} shadow-lg transition-all duration-1000 ease-out flex items-center justify-end pr-2"
                                     style="width: {{ $category->progress }}%">
                                     @if($category->progress > 10)
                                        <span class="text-[9px] font-black text-white/90 animate-pulse">
                                            {{ floor($category->progress) }}%
                                        </span>
                                     @endif
                                </div>
                                <!-- Pattern overlay for progress bar -->
                                <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(255,255,255,0.5) 5px, rgba(255,255,255,0.5) 10px);"></div>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('learn.session', ['mode' => 'category', 'name' => $category->slug]) }}" wire:navigate
                                   class="w-full md:w-auto inline-flex justify-center items-center gap-2 px-8 py-3 bg-body text-surface rounded-xl font-black shadow-lg hover:shadow-xl hover:bg-black transition-all active:scale-95 group/btn">
                                    <span>{{ $category->progress == 100 ? 'Rejouer le niveau' : 'Jouer !' }}</span>
                                    <span class="transform group-hover/btn:translate-x-1 transition-transform">🎮</span>
                                </a>
                            </div>
                            @else
                            <div class="bg-primary/5 rounded-xl p-3 border border-dashed border-primary/20 text-center">
                                <p class="text-xs font-bold text-muted uppercase tracking-widest">
                                    ⚠️ Zone Secrète
                                </p>
                                <p class="text-sm font-medium text-body mt-1">
                                    Complète 80% du niveau précédent pour déverrouiller !
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endisset
        </div>
        
        <div class="h-24"></div> <!-- Spacer -->
    </div>
</x-app-layout>
