<x-app-layout>
    <div class="py-6 bg-app min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-10 text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-body tracking-tight">
                    {{ __('Grammar Buddies') }}
                </h1>
                <p class="text-muted font-medium mt-2 text-lg">
                    {{ __('Tes compagnons d\'apprentissage et leurs exploits') }}
                </p>
            </div>

            @if ($friends->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($friends as $friend)
                        <div class="group relative bg-surface rounded-2xl border border-muted p-6 transition-all duration-300 hover:shadow-xl hover:border-primary/30">
                            <!-- Top Profile Info -->
                            <div class="flex items-center gap-4 mb-6">
                                <div class="relative shrink-0">
                                    <div class="absolute -inset-1 bg-linear-to-tr from-primary to-purple-500 rounded-full blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                                    <div class="relative size-14 rounded-full bg-app flex items-center justify-center text-primary font-bold overflow-hidden border-2 border-surface">
                                        <x-user-avatar :user="$friend"/>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-bold text-body truncate group-hover:text-primary transition-colors">
                                        {{ $friend->username }}
                                    </h4>
                                    @if($friend->role === 'admin')
                                        <span class="inline-flex text-[10px] font-bold px-2 py-0.5 bg-yellow-500/10 text-yellow-600 rounded-full uppercase tracking-widest">
                                            Admin
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
                                <div class="bg-app/50 rounded-xl p-3 border border-muted/50">
                                    <div class="flex items-center gap-2 mb-1">
                                        <x-lucide-flame class="size-4 text-orange-500" />
                                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider">{{ __('Série') }}</span>
                                    </div>
                                    <p class="text-lg font-bold text-body">
                                        {{ $friend->current_streak }} {{ __('J') }}
                                    </p>
                                </div>
                                <div class="bg-app/50 rounded-xl p-3 border border-muted/50">
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
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12">
                    {{ $friends->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="max-w-md mx-auto py-20 text-center">
                    <div class="relative mb-8 inline-flex">
                        <div class="absolute -inset-4 bg-primary/10 rounded-full blur-2xl"></div>
                        <div class="relative w-24 h-24 bg-surface border border-muted rounded-3xl flex items-center justify-center text-5xl">
                            🤝
                        </div>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-body mb-3">{{ __('Aucun Grammar Buddy') }}</h2>
                    <p class="text-muted font-medium mb-10 leading-relaxed text-lg">
                        {{ __('Connecte-toi avec d\'autres apprenants pour suivre leurs progrès et t\'en inspirer !') }}
                    </p>
                    <a href="{{ route('leaderboard', ['locale' => app()->getLocale()]) }}" wire:navigate
                        class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                        <x-lucide-search class="size-5" />
                        {{ __('Trouver des amis') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

