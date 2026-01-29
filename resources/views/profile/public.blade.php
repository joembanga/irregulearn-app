@section('title', $user->username)
@section('description', $user->username . __(' sur IrreguLearn'))
@section('keywords', '...')
@section('og_title', $user->username . __(' sur IrreguLearn'))
@section('og_description', __('Viens voir mon profil et essaie de battre mon record de ') . $user->current_streak . __(' jours de série sur IrreguLearn !'))
@section('og_image', route('share.image', ['type' => 'profile', 'identifier' => $user->username]))
<x-app-layout>
    @php
    $isFriend = DB::table('friendships')
        ->where(function($q) use ($user) {
            $q->where('sender_id', auth()->id())
                ->where('recipient_id', $user->id);
        })
        ->where('status', 'accepted')
        ->exists();
    @endphp

    <div class="py-2 bg-app min-h-screen">
        <div class="max-w-5xl mx-auto space-y-8 px-4">

            <!-- Hero Profile Section -->
            <div class="p-6 md:p-10 relative overflow-hidden">

                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 md:gap-10">
                    <div class="relative">
                        <div class="relative size-32 md:size-40 bg-surface rounded-full flex items-center justify-center text-4xl text-muted font-bold shadow-2xl border-4 border-surface overflow-hidden">
                            <x-user-avatar :user="$user" />
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left space-y-2">
                        <div>
                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider mb-3 animate-pulse">
                                {{ $user->level_name }}
                            </div>
                            <h1 class="text-4xl md:text-5xl mb-2 font-bold text-body ">
                                {{ $user->username }}
                            </h1>
                            <p class="text-muted font-medium mt-1">{{ __('A rejoint la plateforme depuis') }}
                                {{ $user->created_at->format('M Y') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap justify-center md:justify-start gap-3">
                            @if(auth()->id() !== $user->id)
                            <livewire:follow-button :user="$user" />
                            @endif
                            <x-share-button :title="$user->username . ' ' . __('sur') . ' IrreguLearn'"
                                :text="__('Viens voir mon profil sur IrreguLearn et apprends les verbes irréguliers avec moi !')"
                                :url="route('profile.public', ['locale' => app()->getLocale(), 'user' => $user->username])" class="mt-6" />
                        </div>
                    </div>
                </div>
            </div>

            @if($isFriend)
            <livewire:transfer-points :receiver="$user" />
            @endif

            <!-- Stats Grid -->
            <div class="card-surface p-8 rounded-xl border border-muted flex flex-row items-center justify-around text-center group">
                <!-- Streak Card -->
                <div class="flex flex-col items-center justify-center gap-2">
                    <x-lucide-flame class="size-6 stroke-orange-600 fill-orange-600" stroke-width="1.5" />
                    <p class="text-[10px] font-bold text-muted uppercase  mb-1">{{ __('Série') }}</p>
                    <p class="text-2xl font-bold text-body">{{ $user->current_streak }} {{ __('jours') }}</p>
                </div>

                <!-- XP Card -->
                <div class="flex flex-col items-center justify-center gap-2">
                    <x-lucide-zap class="size-6 stroke-yellow-500 fill-yellow-300" stroke-width="1.5" />
                    <p class="text-[10px] font-bold text-muted uppercase  mb-1">{{ __('XP Hebdo') }}</p>
                    <p class="text-2xl font-bold text-body">{{ number_format($user->xp_weekly) }}</p>
                </div>

                <!-- Verbs Card -->
                <div class="flex flex-col items-center gap-2">
                    <x-lucide-book-check class="size-6 justify-center stroke-purple-900 fill-purple-600" stroke-width="1.5" />
                    <p class="text-[10px] font-bold text-muted uppercase mb-1">verbes appris</p>
                    <p class="text-2xl font-bold text-body">
                        {{ $user->learnedVerbs()->count() }}
                    </p>
                </div>
            </div>

            <!-- Badges Section -->
            <div class="card-surface p-8 md:p-12 rounded-xl border border-muted bg-surface/50 backdrop-blur-sm shadow-inner mt-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                    <div>
                        <h3 class="text-2xl font-bold text-body uppercase er">{{ __('Collections de Badges') }}</h3>
                        <p class="text-xs text-muted font-medium mt-1">{{ __('Débloque des badges en progressant dans l\'application.') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="px-3 py-1 bg-primary text-white text-[10px] font-bold rounded-full uppercase tracking-widest shadow-lg shadow-primary/20">
                            {{ $user->badges->count() }} / {{ $allBadges->count() }} {{ __('débloqués') }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                    @foreach($allBadges as $badge)
                        <x-badge :badge="$badge" :unlocked="in_array($badge->id, $userBadgeIds)" />
                    @endforeach
                </div>
            </div>

            <!-- Community Examples Section -->
            @if($examples->count() > 0)
            <div class="card-surface p-8 md:p-12 rounded-xl border border-muted">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-2xl font-bold text-body uppercase er">{{ __('Exemples de la Communauté') }}</h3>
                    <span class="text-xs font-bold text-muted uppercase tracking-widest">{{ $examples->total() }} {{ __('exemples') }}</span>
                </div>

                <div class="space-y-6">
                    @foreach($examples as $example)
                    <div class="card-surface rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-200 border border-surface">
                        <!-- Verb Link & Date -->
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <a href="{{ route('verbs.show', ['locale' => app()->getLocale(), 'verb' => $example->verb->slug]) }}"
                                class="text-2xl font-bold text-primary hover:text-primary-dark transition-colors">
                                {{ $example->verb->infinitive }}
                            </a>
                            <p class="text-xs text-muted">
                                {{ $example->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <!-- Example Body -->
                        <div class="mb-4 p-4 bg-app rounded-lg border border-surface">
                            <p class="text-body leading-relaxed text-lg italic">
                                "{{ $example->body }}"
                            </p>
                        </div>

                        <!-- Stats & Actions -->
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
                                    <livewire:delete-example :exampleId="$example->id" :key="'delete-profile-'.$example->id" />
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($examples->hasPages())
                <div class="mt-8">
                    {{ $examples->links() }}
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-app-layout>