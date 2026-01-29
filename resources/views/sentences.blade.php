<x-app-layout>
    <div class="py-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-body">{{ __('Exemples de la communauté') }}</h1>
            <p class="text-muted font-medium mt-2 text-lg">
                {{ __('Les exemples proposés par la communauté') }}
            </p>
        </div>

            @forelse($examples as $example)
                <!-- Examples List -->
                <div class="space-y-6">
                    <div class="card-surface rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-surface group">
                            <!-- User Info Header -->
                            <div class="flex items-center justify-between gap-4 mb-6">
                                <div class="flex items-center gap-4">
                                    <div class="relative shrink-0">
                                        <div class="relative size-14 rounded-full bg-app flex items-center justify-center text-muted font-bold overflow-hidden border-2 border-surface">
                                            <x-user-avatar :user="$example->user" />
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('profile.public', ['locale' => app()->getLocale(), 'user' => $example->user->username]) }}" 
                                           class="text-lg font-bold text-body hover:text-primary transition-colors block truncate">
                                            {{ $example->user->username }}
                                        </a>
                                        @if(in_array($example->user->id, $friendsIds))
                                            <span class="inline-flex text-[10px] font-bold px-2 py-0.5 bg-yellow-500/10 text-yellow-600 dark:text-yellow-500 rounded-full uppercase tracking-widest">
                                                {{ __('Gram Bud') }}
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-muted uppercase tracking-widest">
                                                {{ $example->user->level_name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Date -->
                                <p class="text-xs text-muted">
                                    {{ $example->created_at->format('d M Y') }}
                                </p>
                            </div>

                            <!-- Verb Link -->
                            <div class="mb-5">
                                <a href="{{ route('verbs.show', ['locale' => app()->getLocale(), 'verb' => $example->verb->slug]) }}" 
                                   class="inline-flex items-center gap-2 text-3xl md:text-4xl font-bold text-primary hover:text-primary-dark transition-colors group/verb">
                                    {{ $example->verb->infinitive }}
                                    <svg class="w-6 h-6 opacity-0 group-hover/verb:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>

                            <!-- Example Body -->
                            <div class="mb-6 p-5 bg-app rounded-xl border border-surface">
                                <p class="text-body leading-relaxed text-lg md:text-xl italic">
                                    "{{ $example->body }}"
                                </p>
                            </div>

                            <!-- Stats & Actions -->
                            <div class="flex flex-wrap gap-4 items-center justify-between">
                                    <!-- Likes Count -->
                                    <div class="flex items-center gap-2">
                                        <x-lucide-heart class="size-6 fill-red-500" />
                                        <span class="font-semibold text-body">{{ $example->likes_count }}</span>
                                        <span class="text-xs text-muted">{{ __('likes') }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-3">
                                    <a href="{{ route('verbs.show', ['locale' => app()->getLocale(), 'verb' => $example->verb->slug]) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 text-primary rounded-lg font-semibold text-sm hover:bg-primary/20 transition active:scale-95 shadow-sm">
                                        {{ __('View Verb') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>

                                    @if($example->user_id === auth()->id())
                                        <livewire:delete-example :exampleId="$example->id" :key="'delete-'.$example->id" />
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $examples->links() }}
                </div>
            @empty
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-6 text-center">
                    <x-lucide-wind class="size-20 text-muted mb-6" />
                    <h2 class="text-3xl font-bold text-body mb-3">{{ __('Aucun exemple pour le moment') }}</h2>
                    <p class="text-muted mb-8 max-w-md text-lg">{{ __('Commence à contribuer des exemples de verbes pour aider la communauté à apprendre.') }}</p>
                    <a href="{{ route('verbs.index', ['locale' => app()->getLocale()]) }}" wire:navigate
                       class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all active:scale-95 shadow-lg hover:shadow-xl">
                        {{ __('Parcourir les verbes') }}
                    </a>
                </div>
            @endforelse
    </div>
</x-app-layout>
