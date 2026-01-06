<nav x-data="nav()" class="bg-app border-b border-muted fixed w-full z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="bg-primary text-surface p-2 rounded-md font-bold">IL</div>
                    <span class="hidden sm:inline font-bold text-lg text-body">Irregu<span
                            class="text-primary">Learn</span></span>
                </a>
            </div>

            <!-- Desktop nav & search -->
            <div class="hidden md:flex md:items-center md:space-x-6 flex-1 justify-center">
                <div class="flex items-center space-x-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('learn.index')" :active="request()->routeIs('learn.index')">Apprendre</x-nav-link>
                    <x-nav-link :href="route('leaderboard')" :active="request()->routeIs('leaderboard')">Classement
                    </x-nav-link>
                    <x-nav-link :href="route('verbs.index')" :active="request()->routeIs('verbs.index')">Verbes</x-nav-link>
                    <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">Boutique</x-nav-link>
                </div>

                <form action="{{ route('search') }}" method="GET" class="ml-8 hidden lg:block">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
                            <svg class="h-4 w-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input name="q" type="search" placeholder="Rechercher..."
                            class="w-64 pl-9 pr-4 py-2 rounded-xl bg-surface text-body text-xs focus:ring-2 focus:ring-primary/50 transition-all placeholder:text-muted/60" />
                    </div>
                </form>
            </div>

            <!-- Right actions (desktop) -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Streak (flamme) -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 px-2 py-1 rounded-md hover:bg-surface transition"
                    aria-label="Série actuelle">
                    <span class="text-xl" role="img" aria-hidden="true">🔥</span>
                    <span class="text-sm font-semibold text-body">{{ Auth::user()->streak ?? (Auth::user()->current_streak ?? 0) }}</span>
                </a>

                <button @click="toggleTheme" class="p-2 rounded-md hover:bg-surface transition">
                    <svg x-cloak x-show="!isDark" class="h-6 w-6 text-warning" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v2.25M12 18.75V21M4.22 4.22l1.59 1.59M18.19 18.19l1.59 1.59M1 12h2.25M20.75 12H23M4.22 19.78l1.59-1.59M18.19 5.81l1.59-1.59" />
                    </svg>
                    <svg x-cloak x-show="isDark" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>

                <livewire:notification-icon />

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-3 py-2 rounded-md bg-app border border-muted">
                            <div class="h-8 w-8 rounded-full bg-primary/20 dark:bg-primary/20 flex items-center justify-center text-primary font-bold">
                                {{ substr(Auth::user()->username, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-body">{{ Auth::user()->username }}</div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.public', auth()->user()->username)">Ma Page Publique</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">Paramètres</x-dropdown-link>
                        <div class="border-t border-muted my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Se déconnecter
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile icons / hamburger -->
            <div class="flex items-center md:hidden gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1 p-2 text-muted"
                    aria-label="Série actuelle">
                    <span class="text-lg" role="img" aria-hidden="true">🔥</span>
                    <span class="text-xs font-semibold">{{ Auth::user()->streak ?? (Auth::user()->current_streak ?? 0) }}</span>
                </a>

                <a href="{{ route('search') }}" class="p-2 text-muted">
                    <svg class="h-6 w-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </a>
                <livewire:notification-icon />
                <button @click="open = true" aria-label="Menu" class="p-2">
                    <svg class="h-6 w-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
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
            class="absolute right-0 top-0 h-full w-full sm:w-96 bg-surface/90 backdrop-blur-xl shadow-2xl p-8 overflow-auto border-l border-white/10">
            <div class="flex items-center justify-between mb-10">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="bg-primary text-surface p-2 rounded-xl font-bold shadow-lg shadow-primary/20">IL</div>
                    <span class="font-black text-xl text-body tracking-tight">Irregu<span class="text-primary">Learn</span></span>
                </a>
                <button @click="open = false" class="p-2 text-muted hover:text-body transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-10">
                <form action="{{ route('search') }}" method="GET">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        <input name="q" type="search" placeholder="Rechercher un verbe..."
                            class="w-full pl-12 pr-4 py-4 rounded-2xl bg-app border-none text-body text-sm focus:ring-2 focus:ring-primary/50 transition-all font-medium" />
                    </div>
                </form>
            </div>

            <nav class="flex flex-col gap-2">
                <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] px-4 mb-2">Navigation</p>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">🏠</span> Dashboard
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('learn.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">⚡</span> Apprendre
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('leaderboard') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">🏆</span> Classement
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('shop') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">🛒</span> Boutique
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
                <a href="{{ route('verbs.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-2xl font-black text-body hover:bg-primary/5 hover:text-primary transition-all group overflow-hidden relative">
                    <span class="text-xl">📖</span> Les Verbes
                    <div class="absolute right-0 top-0 h-full w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform origin-bottom"></div>
                </a>
            </nav>

            <div class="mt-auto pt-10 border-t border-muted/50 space-y-6">
                <div>
                    <p class="text-[10px] font-bold text-muted uppercase tracking-[0.2em] px-4 mb-4">Préférences</p>
                    <button @click="toggleTheme" class="w-full flex items-center justify-between px-6 py-4 rounded-2xl bg-app text-body font-bold transition-transform active:scale-95">
                        <span class="flex items-center gap-3">
                            <span x-show="!isDark">☀️</span>
                            <span x-show="isDark">🌙</span>
                            Mode <span x-text="isDark ? 'Clair' : 'Sombre'"></span>
                        </span>
                        <div class="w-10 h-6 bg-muted/20 rounded-full relative">
                            <div class="absolute top-1 left-1 w-4 h-4 bg-primary rounded-full transition-transform" :class="isDark ? 'translate-x-4' : ''"></div>
                        </div>
                    </button>
                </div>

                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl hover:bg-primary/5 transition-all">
                    <div class="h-14 w-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-black text-xl shadow-inner group-hover:scale-110 transition-transform">
                        {{ substr(Auth::user()->username, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-black text-body group-hover:text-primary transition-colors">{{ Auth::user()->username }}</div>
                        <div class="text-xs font-bold text-muted uppercase tracking-widest">Voir mon profil</div>
                    </div>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-5 rounded-2xl bg-danger/10 text-danger font-black text-sm uppercase tracking-widest hover:bg-danger hover:text-surface transition-all active:scale-95">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </aside>
    </div>
</nav>