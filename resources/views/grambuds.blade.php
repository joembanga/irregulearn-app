<x-app-layout>
    <div class="py-2 bg-app">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6 md:mb-10 text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-body">
                    {{ __('Grammar Buddies') }}
                </h1>
                <p class="text-muted font-medium mt-2 text-lg">
                    {{ __('Tes compagnons d\'apprentissage et leurs exploits') }}
                </p>
            </div>

            @forelse ($friends as $friend)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="group relative bg-surface rounded-2xl border border-muted p-6 transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                            <!-- Top Profile Info -->
                            <div class="flex items-center gap-4 mb-6">
                                <div class="relative shrink-0">
                                    @php
                                    $userId = $friend->id;
                                    $size1 = 14;
                                    @endphp
                                    <livewire:user-avatar :$userId :$size1/>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-bold text-body truncate group-hover:text-primary transition-colors">
                                        {{ $friend->username }}
                                    </h4>
                                    @if($friend->role === 'admin')
                                        <span class="inline-flex text-[10px] font-bold px-2 py-0.5 bg-yellow-500/10 text-yellow-600 rounded-full uppercase tracking-widest">
                                            {{ __('Admin') }}
                                        </span>
                                    @else
                                        <span class="text-xs font-bold text-muted uppercase tracking-widest">
                                            {{ $friend->level_name }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- User Stats -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-app/50 rounded-xl p-3 border border-muted">
                                    <div class="flex items-center gap-2 mb-1">
                                        <x-lucide-flame class="size-4 text-orange-500" />
                                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider">{{ __('Série') }}</span>
                                    </div>
                                    <p class="text-lg font-bold text-body">
                                        {{ $friend->current_streak }} {{ __('J') }}
                                    </p>
                                </div>
                                <div class="bg-app/50 rounded-xl p-3 border border-muted">
                                    <div class="flex items-center gap-2 mb-1">
                                        <x-lucide-zap class="size-4 text-yellow-500" />
                                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider">{{ __('XP Hebdo') }}</span>
                                    </div>
                                    <p class="text-lg font-bold text-body">
                                        {{ number_format($friend->xp_weekly) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Action -->
                            <a href="{{ route('profile.public', ['locale' => app()->getLocale(), 'user' => $friend->username]) }}" wire:navigate
                                class="w-full flex items-center justify-center gap-2 py-3 bg-app hover:bg-primary hover:text-white rounded-xl text-sm font-bold border border-muted transition-all active:scale-[0.98]">
                                {{ __('Voir le profil') }}
                                <x-lucide-arrow-right class="size-4" />
                            </a>
                        </div>
                </div>
                
                <!-- Pagination -->
                <div class="mt-12">
                    {{ $friends->links() }}
                </div>
            @empty
                <!-- Empty State -->
                <div class="max-w-md mx-auto py-20 text-center">
                    <div class="relative mb-8 inline-flex">
                        <div class="relative w-24 h-24 bg-surface border border-muted rounded-2xl flex items-center justify-center text-5xl">
                            <x-lucide-users class="size-14" />
                        </div>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-body mb-3">{{ __('Tu n\'as pas encore de GramBud') }}</h2>
                    <p class="text-muted font-medium mb-10 leading-relaxed text-lg">
                        {{ __('Connecte-toi avec d\'autres apprenants pour suivre leurs progrès et t\'en inspirer !') }}
                    </p>
                    <a href="{{ route('leaderboard', ['locale' => app()->getLocale()]) }}" wire:navigate
                        class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white font-bold rounded-xl hover:scale-105 active:scale-95 transition-all">
                        <x-lucide-search class="size-5" />
                        {{ __('Trouver des amis') }}
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

