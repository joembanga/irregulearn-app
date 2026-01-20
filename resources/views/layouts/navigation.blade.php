<nav class="bg-app fixed w-full z-50">
    <div class="px-4 mb-4 md:mb-0 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left: Logo & Sidebar Toggles -->
            <div class="flex items-center gap-4">
                <!-- Mobile & Desktop Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 rounded-xl text-muted hover:bg-surface hover:text-primary cursor-pointer transition-all duration-200"
                        aria-label="Toggle Sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h10M4 18h16" />
                    </svg>
                </button>
                
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                    <x-application-logo />
                </a>
            </div>

            <!-- Center: Reactive Search Bar -->
            <div class="w-full hidden md:flex items-center justify-center">
                <livewire:global-search />
            </div>

            <!-- Right: Actions -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Streak -->
                <div x-data="{ showStreak: false }" class="relative">
                    <button @mouseenter="showStreak = true" @mouseleave="showStreak = false" @click="showStreak = !showStreak"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-surface transition-colors">
                        <span class="text-xl {{ (Auth::user()->streak_freezes > 0 && Auth::user()->streak_is_freezed) ? 'text-blue-400' : 'text-body' }}">
                            <x-lucide-flame class="size-6 fill-current" />
                        </span>
                        <span class="text-sm font-bold text-body">{{ Auth::user()->current_streak ?? 0 }}</span>
                    </button>

                    <!-- Streak Popover -->
                    <div x-show="showStreak" x-transition x-cloak
                        class="absolute top-full right-0 mt-2 w-72 bg-surface border border-muted rounded-2xl shadow-xl p-5 z-50"
                        x-data="{ 
                            timeLeft: '', 
                            expiry: '{{ Auth::user()->streak_expires_at ? Auth::user()->streak_expires_at->toIso8601String() : '' }}',
                            updateTimer() {
                                if (!this.expiry) { this.timeLeft = '{{ __('Expiré') }}'; return; }
                                const now = new Date();
                                const target = new Date(this.expiry);
                                const diff = target - now;
                                if (diff <= 0) { this.timeLeft = '{{ __('Expiré') }}'; return; }
                                const h = Math.floor(diff / 3600000);
                                const m = Math.floor((diff % 3600000) / 60000);
                                const s = Math.floor((diff % 60000) / 1000);
                                this.timeLeft = `${h}h ${m}m ${s}s`;
                            }
                        }"
                        x-init="updateTimer(); setInterval(() => updateTimer(), 1000)">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-2xl shrink-0">🔥</div>
                            <div>
                                <h4 class="font-bold text-body text-lg leading-tight">{{ __('Série de flammes') }}</h4>
                                <p class="text-muted text-xs mt-1 leading-relaxed">
                                    {{ __('Pratique chaque jour pour faire grandir ta série !') }}
                                    <br>
                                    <span class="text-primary font-bold">{{ __('Expire dans :') }} </span>
                                    <span class="font-mono text-primary font-bold" x-text="timeLeft"></span>
                                </p>
                            </div>
                        </div>
                        <div class="bg-app rounded-xl p-3 flex justify-between items-center border border-muted">
                            <span class="text-xs font-bold text-muted uppercase">{{ __('Record') }}</span>
                            <span class="font-bold text-body">{{ Auth::user()->best_streak ?? 0 }} {{ __('Jours') }}</span>
                        </div>
                    </div>
                </div>

                <livewire:notification-icon />

                <div class="h-8 w-0.5 bg-surface"></div>

                <!-- User Profile -->
                <x-dropdown align="right" class="w-auto">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 p-1 rounded-xl hover:bg-surface transition-colors">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black truncate">
                                <x-user-avatar :user="Auth::user()" />
                            </div>
                            <svg class="w-4 h-4 text-muted hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-muted">
                            <p class="text-sm font-bold text-body truncate">{{ Auth::user()->username }}</p>
                            <p class="text-xs text-muted truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="flex items-center gap-2">
                                <x-lucide-user-round-cog class="size-5" />
                                {{ __('Modifier mon profil') }}</span>
                        </x-dropdown-link>

                        <button @click="toggleTheme" class="w-full flex items-center justify-between px-4 py-2 text-sm text-muted hover:bg-muted/10 transition-colors">
                            <span class="flex items-center gap-2">
                                <span x-show="!isDark">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                    </svg>
                                </span>
                                <span x-show="isDark">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                    </svg>
                                </span>
                                {{ __('Mode') }}
                            </span>
                            <div class="w-8 h-4 bg-muted/20 rounded-full relative">
                                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-primary rounded-full transition-transform" :class="isDark ? 'translate-x-4' : ''"></div>
                            </div>
                        </button>

                        <div class="border-t border-muted my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="#"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-danger flex flex-row gap-2 items-center">
                                {{ __('Se déconnecter') }}
                                <span>
                                    <x-lucide-log-out class="size-5" />
                                </span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <!-- Center: Reactive Search Bar -->
        <div class="w-full flex md:hidden items-center justify-center">
            <livewire:global-search />
        </div>
    </div>
</nav>
