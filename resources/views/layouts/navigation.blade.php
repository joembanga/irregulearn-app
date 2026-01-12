<nav x-data="nav()" class="bg-app border-b border-muted fixed w-full z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                    <x-application-logo />
                </a>
            </div>

            <!-- Desktop nav & search -->
            <div class="hidden md:flex md:items-center md:space-x-6 flex-1 justify-center">
                <div class="flex items-center space-x-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('learn.index')" :active="request()->routeIs('learn.index')" wire:navigate>{{ __('Apprendre') }}</x-nav-link>
                    <x-nav-link :href="route('leaderboard')" :active="request()->routeIs('leaderboard')" wire:navigate>{{ __('Classement') }}
                    </x-nav-link>
                    <x-nav-link :href="route('verbs.index')" :active="request()->routeIs('verbs.index')" wire:navigate>{{ __('Verbes') }}</x-nav-link>
                    <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')" wire:navigate>{{ __('Boutique') }}</x-nav-link>
                </div>

                <form action="{{ route('search') }}" method="GET" class="ml-8 hidden lg:block">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
                            <svg class="h-4 w-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input name="q" type="search" placeholder="{{ __('Recherche') }}..."
                            class="w-64 pl-9 pr-4 py-2 rounded-xl bg-surface text-body text-xs focus:ring-2 focus:ring-primary/50 transition-all placeholder:text-muted/60" />
                    </div>
                </form>
            </div>

            <!-- Right actions (desktop) -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Streak (flamme) -->
                <div x-data="{ showStreak: false }" class="relative z-50">
                    <button 
                        @mouseenter="showStreak = true" 
                        @mouseleave="showStreak = false"
                        class="flex items-center gap-2 px-2 py-1 rounded-md hover:bg-surface transition"
                        aria-label="{{ __('Série actuelle') }}">
                        <span class="text-xl {{ (Auth::user()->streak_freezes > 0 && Auth::user()->streak_is_freezed) ? 'text-blue-400' : 'text-orange-500' }}" role="img" aria-hidden="true">🔥</span>
                        <span class="text-sm font-semibold text-body">{{ Auth::user()->current_streak ?? 0 }}</span>
                    </button>

                    <!-- Popover -->
                    <div x-show="showStreak" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-full -right-4 mt-2 w-72 bg-surface border border-muted rounded-2xl shadow-xl p-5 z-50"
                        x-cloak
                        @mouseenter="showStreak = true" 
                        @mouseleave="showStreak = false"
                    >
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-2xl flex-shrink-0">
                                🔥
                            </div>
                            <div>
                                <h4 class="font-black text-body text-lg leading-tight">{{ __('Série de flammes') }}</h4>
                                <p class="text-muted text-xs mt-1 leading-relaxed">{{ __('Pratique chaque jour pour faire grandir ta série et gagner des bonus !') }}</p>
                            </div>
                        </div>

                        <div class="bg-app rounded-xl p-3 flex justify-between items-center mb-4 border border-muted">
                            <span class="text-xs font-bold text-muted uppercase">{{ __('Record Personnel') }}</span>
                            <span class="font-black text-body">{{ Auth::user()->best_streak ?? 0 }} {{ __('Jours') }}</span>
                        </div>

                        <div class="flex gap-2">
                             <div class="flex-1 bg-blue-50 bg-opacity-50 border border-blue-100 rounded-xl p-2 flex flex-col items-center">
                                 <span class="text-lg">❄️</span>
                                 <span class="text-[10px] font-bold text-blue-600 uppercase mt-1">{{ __('Gels') }}: {{ Auth::user()->streak_freezes }}</span>
                             </div>
                             <a href="{{ route('shop') }}" class="flex-1 bg-primary text-surface rounded-xl p-2 flex items-center justify-center text-xs font-bold hover:opacity-90 transition">
                                 {{ __('Aller à la boutique') }}
                             </a>
                        </div>
                    </div>
                </div>

                <livewire:notification-icon />

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-3 py-2 rounded-md bg-app border border-muted">
                            <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                                {{ substr(Auth::user()->username, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-body">{{ Auth::user()->username }}</div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.public', auth()->user()->username)">{{ __('Ma Page Publique') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Paramètres') }}</x-dropdown-link>
                        <button @click="toggleTheme" class="w-full flex items-center gap-3 px-4 py-2 text-sm justify-between transition" >
                            <span x-text="isDark ? '{{ __('Sombre') }}' : '{{ __('Clair') }}'"></span>
                            <span class="flex flex-row gap-2 items-center justify-between bg-primary/20 rounded-full relative p-1.5 overflow-hidden">
                                <div class="absolute top-0 bottom-1 left-0 w-[50%] h-full bg-primary transition-all ease-linear"
                                    :class="isDark ? 'translate-x-full' : 'translate-x-0'"></div>
                                <svg x-cloak class="w-4 h-4 z-10 transition-colors duration-300 " :class="!isDark ? 'text-white' : 'text-muted'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.93 4.93l1.41 1.41" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.66 17.66l1.41 1.41" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.93 19.07l1.41-1.41" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.66 6.34l1.41-1.41" />
                                </svg>
                                <svg x-cloak class="w-4 h-4 z-10 transition-colors duration-300 " :class="isDark ? 'text-white' : 'text-muted'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                                </svg>
                            </span>
                        </button>
                        <div class="border-t border-muted my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-danger">
                                {{ __('Se déconnecter') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile icons / hamburger -->
            <div class="flex flex-row items-center justify-betwen md:hidden gap-1.5">
                <a href="{{ route('search') }}" class="h-6 w-6 p-1 text-muted border border-muted rounded-full" wire:navigate>
                    <svg class="text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </a>
                <livewire:notification-icon />
                <div x-data="{ showStreakMobile: false }" class="relative" @click.away="showStreakMobile = false">
                    <button @click="showStreakMobile = !showStreakMobile" class="flex items-center gap-0 p-1 text-muted" aria-label="{{ __('Série actuelle') }}">
                        <span class="w-6 h-6" role="img" aria-hidden="true">🔥</span>
                        <span class="text-xs font-semibold">{{ Auth::user()->current_streak ?? 0 }}</span>
                    </button>

                    <!-- Mobile Popover -->
                    <div x-show="showStreakMobile" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute top-10 right-[-60px] w-72 bg-surface border border-muted rounded-2xl shadow-xl p-5 z-50"
                         x-cloak>
                        
                        <div class="flex items-start gap-4 mb-4 text-left">
                            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-2xl flex-shrink-0">
                                🔥
                            </div>
                            <div>
                                <h4 class="font-black text-body text-lg leading-tight">{{ __('Série de flammes') }}</h4>
                                <p class="text-muted text-xs mt-1 leading-relaxed">{{ __('Pratique chaque jour pour faire grandir ta série et gagner des bonus !') }}</p>
                            </div>
                        </div>

                        <div class="bg-app rounded-xl p-3 flex justify-between items-center mb-4 border border-muted">
                            <span class="text-xs font-bold text-muted uppercase">{{ __('Record Personnel') }}</span>
                            <span class="font-black text-body">{{ Auth::user()->best_streak ?? 0 }} {{ __('Jours') }}</span>
                        </div>

                        <div class="flex gap-2">
                             <div class="flex-1 bg-blue-50 bg-opacity-50 border border-blue-100 rounded-xl p-2 flex flex-col items-center">
                                 <span class="text-lg">❄️</span>
                                 <span class="text-[10px] font-bold text-blue-600 uppercase mt-1">{{ __('Gels') }}: {{ Auth::user()->streak_freezes }}</span>
                             </div>
                             <a href="{{ route('shop') }}" class="flex-1 bg-primary text-surface rounded-xl p-2 flex items-center justify-center text-center text-xs font-bold hover:opacity-90 transition">
                                 {{ __('Aller à la boutique') }}
                             </a>
                        </div>
                    </div>
                </div>
                <button @click="open = true" aria-label="Menu" class="p-2">
                    <svg class="h-7 w-7 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile full-screen menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-cloak
        class="fixed inset-0 z-50">
        <div @click="open = false" class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>

        <aside x-show="open" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-full sm:w-96 bg-surface/95 backdrop-blur-xl shadow-2xl p-8 overflow-auto border-l border-white/5">
            <div class="flex items-center justify-between mb-5">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                    <x-application-logo />
                    <span class="font-bold text-xl tracking-tight text-body">
                        Irregu<span class="text-primary">Learn</span>
                    </span>
                </a>
                <button @click="open = false" class="p-2 text-muted hover:text-body transition-colors">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <a href="{{ route('profile.edit') }}" wire:navigate
                class="group flex items-center gap-4 px-4 py-4 mb-5 rounded-2xl hover:bg-primary/5 transition-all">
                <div
                    class="h-14 w-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-black text-xl shadow-inner group-hover:scale-110 transition-transform">
                    {{ substr(Auth::user()->username, 0, 1) }}
                </div>
                <div>
                    <div class="font-black text-body group-hover:text-primary transition-colors">{{ Auth::user()->username }}</div>
                    <div class="text-xs font-bold text-muted uppercase tracking-widest">{{ __('Voir mon profil') }}</div>
                </div>
            </a>

            <nav class="flex flex-col gap-2">
                <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] px-4 mb-2">Navigation</p>
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">🏠</span> {{ __('Dashboard') }}
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('learn.index') }}" wire:navigate class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">⚡</span> {{ __('Apprendre') }}
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('leaderboard') }}" wire:navigate class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">🏆</span> {{ __('Classement') }}
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('shop') }}" wire:navigate class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">🛒</span> {{ __('Boutique') }}
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('verbs.index') }}" wire:navigate class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">📖</span> {{ __('Les Verbes') }}
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
            </nav>

            <div class="mt-auto pt-10 border-t border-muted/50 space-y-6">
                <div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] px-4 mb-4">{{ __('Paramètres') }}</p>
                    <button @click="toggleTheme" class="w-full flex items-center justify-between px-6 py-4 rounded-2xl bg-app text-body font-bold transition-transform active:scale-95">
                        <span class="flex items-center gap-3">
                            <svg x-cloak x-show="!isDark" class="h-5 w-5 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.93 4.93l1.41 1.41" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.66 17.66l1.41 1.41" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.93 19.07l1.41-1.41" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.66 6.34l1.41-1.41" />
                            </svg>
                            <svg x-cloak x-show="isDark" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                            </svg>
                            {{ __('Mode') }} <span x-text="isDark ? '{{ __('Clair') }}' : '{{ __('Sombre') }}'"></span>
                        </span>
                        <div class="w-10 h-6 bg-muted/20 rounded-full relative">
                            <div class="absolute top-1 left-1 w-4 h-4 bg-primary rounded-full transition-transform" :class="isDark ? 'translate-x-4' : ''"></div>
                        </div>
                    </button>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-5 rounded-2xl bg-danger/10 text-danger font-black text-sm uppercase tracking-widest hover:bg-danger hover:text-surface transition-all active:scale-95">
                        {{ __('Se déconnecter') }}
                    </button>
                </form>
            </div>
        </aside>
    </div>
</nav>