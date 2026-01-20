<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-app text-body transition-colors duration-300 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-body mb-2">{{ __('My Sentences') }}</h1>
                <p class="text-muted text-lg">{{ __('Your contributed verb examples') }}</p>
            </div>

            @if($examples->count() > 0)
                <!-- Examples List -->
                <div class="space-y-6">
                    @foreach($examples as $example)
                        <div class="card-surface rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-200">
                            <!-- Verb Link & Date -->
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex-1">
                                    <a href="{{ route('verbs.show', ['locale' => app()->getLocale(), 'verb' => $example->verb->slug]) }}" 
                                       class="text-2xl font-bold text-primary hover:text-primary-dark transition-colors">
                                        {{ $example->verb->infinitive }}
                                    </a>
                                    <p class="text-xs text-muted mt-1">
                                        {{ $example->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                @if(!$example->is_hidden)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-500/10 text-green-700 text-xs font-semibold rounded-full">
                                        ✓ {{ __('Published') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-gray-500/10 text-gray-700 text-xs font-semibold rounded-full">
                                        🔒 {{ __('Hidden') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Example Body -->
                            <div class="mb-4 p-4 bg-app rounded-lg border border-surface">
                                <p class="text-body leading-relaxed text-lg">
                                    "{{ $example->body }}"
                                </p>
                            </div>

                            <!-- Stats -->
                            <div class="flex flex-wrap gap-4 items-center justify-between">
                                <div class="flex gap-6">
                                    <!-- Likes Count -->
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl">❤️</span>
                                        <span class="font-semibold text-body">{{ $example->likes_count }}</span>
                                        <span class="text-xs text-muted">{{ __('likes') }}</span>
                                    </div>

                                    <!-- XP Earned -->
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl">⭐</span>
                                        <span class="font-semibold text-body">{{ $example->xp_given }}</span>
                                        <span class="text-xs text-muted">XP</span>
                                    </div>
                                </div>

                                <!-- View Button -->
                                <a href="{{ route('verbs.show', ['locale' => app()->getLocale(), 'verb' => $example->verb->slug]) }}" 
                                   class="text-sm font-semibold text-primary hover:text-primary-dark transition-colors">
                                    {{ __('View Verb') }} →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $examples->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="text-6xl mb-4">📝</div>
                    <h2 class="text-2xl font-bold text-body mb-2">{{ __('No sentences yet') }}</h2>
                    <p class="text-muted mb-6 max-w-md">{{ __('Start contributing verb examples to help the community learn.') }}</p>
                    <a href="{{ route('verbs.index', ['locale' => app()->getLocale()]) }}" class="px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark transition-colors">
                        {{ __('Browse Verbs') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
