<nav class="bg-app fixed w-full z-50">
    <div class="px-4 mb-4 md:mb-0 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left: Logo & Sidebar Toggles -->
            <div class="flex items-center gap-4">
                <!-- Mobile & Desktop Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-muted hover:bg-surface hover:text-primary cursor-pointer transition-all duration-200" aria-label="{{ __('Toggle Sidebar') }}">
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
                @auth
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
                        class="absolute top-full -left-50 mt-2 w-84 bg-surface border border-muted rounded-xl shadow-xl p-5 z-50"
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
                        @php
                            $timezone = Auth::user()->timezone ?? 'UTC';
                            $localToday = now($timezone)->toDateString();
                            $lastActivity = Auth::user()->last_activity_local_date ? \Carbon\Carbon::parse(Auth::user()->last_activity_local_date)->toDateString() : null;
                            $isDoneToday = $lastActivity === $localToday;
                        @endphp
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-2xl shrink-0">
                                <x-flame-gradient />
                                <x-lucide-flame class="size-6 stroke-orange-600 fill-[url(#flame-grad)]" stroke-width="1.5" />
                            </div>
                            <div>
                                <h4 class="font-bold text-body text-lg leading-tight">{{ __('Série de flammes') }}</h4>
                                <p class="text-muted text-xs mt-1 leading-relaxed">
                                    @if($isDoneToday)
                                        <span class="text-success font-bold">✅ {{ __('Série sécurisée !') }}</span>
                                        <br>
                                        {{ __('Bravo ! Tu as pratiqué aujourd\'hui.') }}
                                    @else
                                        {{ __('Pratique chaque jour pour faire grandir ta série !') }}
                                        <br>
                                        <span class="text-primary font-bold">{{ __('Expire dans :') }} </span>
                                        <span class="font-mono text-primary font-bold" x-text="timeLeft"></span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="bg-app rounded-xl p-3 flex justify-between items-center border border-muted">
                            <span class="text-xs font-bold text-muted uppercase">{{ __('Record') }}</span>
                            <span class="font-bold text-body">{{ Auth::user()->best_streak ?? 0 }} {{ __('Jours') }}</span>
                        </div>
                    </div>
                </div>
                @endauth

                @auth
                <livewire:notification-icon />

                <div class="h-8 w-0.5 bg-surface"></div>

                <!-- User Profile -->
                <x-dropdown align="right" class="w-auto">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 p-1 rounded-xl hover:bg-surface transition-colors">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-muted font-black truncate">
                                <x-user-avatar :user="Auth::user()" />
                            </div>
                            <svg class="w-4 h-4 text-muted hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-muted">
                            <p class="text-base font-bold text-body truncate">{{ Auth::user()->username }}</p>
                            <p class="text-base text-muted truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="flex items-center gap-2">
                                <x-lucide-user-round-cog class="size-5" />
                                {{ __('Modifier mon profil') }}
                            </span>
                        </x-dropdown-link>

                        <button @click="toggleTheme" class="w-full flex items-center justify-between px-4 py-2 text-sm text-muted hover:bg-muted/10 transition-colors">
                            <span class="flex items-center gap-2">
                                <span x-show="!isDark">
                                    <x-lucide-sun class="size-6" />
                                </span>
                                <span x-show="isDark">
                                    <x-lucide-moon class="size-6" />
                                </span>
                                {{ __('Mode') }}
                            </span>
                            <div class="w-8 h-4 bg-muted/20 rounded-full relative">
                                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-primary rounded-full transition-transform" :class="isDark ? 'translate-x-4' : ''"></div>
                            </div>
                        </button>

                        <div class="border-t border-muted my-1"></div>
                    
                        <x-dropdown-link href="#">
                            {{ __('Centre d\'aide') }}
                        </x-dropdown-link>
                    
                        <x-dropdown-link href="#">
                            {{ __('Contactez-nous') }}
                        </x-dropdown-link>
                    
                        <x-dropdown-link href="#">
                            {{ __('Confidentialité') }}
                        </x-dropdown-link>
                    
                        <div class="border-t border-muted my-1"></div>
                    
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-danger flex flex-row gap-2 items-center">
                                {{ __('Se déconnecter') }}
                                <span>
                                    <x-lucide-log-out class="size-5" />
                                </span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
                
                @guest
                <div class="flex items-center gap-2">
                     <button @click="toggleTheme" class="flex items-center justify-between px-3 py-2 text-sm text-muted hover:bg-surface rounded-xl transition-colors">
                        <span x-show="!isDark">
                            <x-lucide-sun class="size-6" />
                        </span>
                        <span x-show="isDark">
                            <x-lucide-moon class="size-6" />
                        </span>
                    </button>
                    
                    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" wire:navigate
                       class="px-4 py-2 text-sm font-bold text-body hover:text-primary transition-colors">
                        {{ __('Connexion') }}
                    </a>
                    <a href="{{ route('register', ['locale' => app()->getLocale()]) }}" wire:navigate
                       class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:scale-105 transition-all">
                        {{ __('Commencer') }}
                    </a>
                </div>
                @endguest
            </div>
        </div>
        <!-- Center: Reactive Search Bar -->
        <div class="w-full flex md:hidden items-center justify-center">
            <livewire:global-search />
        </div>
    </div>
</nav>
