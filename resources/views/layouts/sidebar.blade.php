<!-- Mobile Backdrop -->
<template x-teleport="body">
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/50 backdrop-blur-lg lg:hidden z-30"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
    </div>
</template>

<aside id="sidebar" 
    class="fixed top-0 left-0 z-40 w-72 lg:w-64 h-screen pt-32 md:pt-20 transition-all duration-300" 
    aria-label="Sidebar"
    x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    x-cloak>
    <div class="h-full px-4 py-6 overflow-y-auto no-scrollbar bg-app">
        <nav class="space-y-4 font-semibold text-body">
            <p class="text-[10px] font-bold text-muted uppercase  px-4 mb-2">{{ __('Navigation principale') }}</p>

            <ul class="text-lg md:text-base space-y-2 list-none p-0">
                <li>
                    <a href="{{ route('dashboard') }}" wire:navigate 
                       class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                        <span class="mr-3 group-hover:scale-110 transition-transform">
                            <x-lucide-house class="size-5 md:size-6" />
                        </span>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('learn.index') }}" wire:navigate 
                       class="flex items-center p-2 md:p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('learn.index') ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                        <span class="mr-3 group-hover:scale-110 transition-transform">
                            <x-heroicon-o-bolt class="size-5 md:size-6"/>
                        </span>
                        <span>{{ __('Entraînement') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('leaderboard') }}" wire:navigate 
                       class="flex items-center p-2 md:p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('leaderboard') ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                        <span class=" mr-3 group-hover:scale-110 transition-transform">
                            <x-lucide-trophy class="size-5 md:size-6" />
                        </span>
                        <span>{{ __('Classement') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('verbs.index') }}" wire:navigate 
                       class="flex items-center p-2 md:p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('verbs.index') ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                        <span class="mr-3 group-hover:scale-110 transition-transform">
                            <x-heroicon-o-book-open class="size-5 md:size-6"/>
                        </span>
                        <span>{{ __('Verbes') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('shop') }}" wire:navigate 
                       class="flex items-center p-2 md:p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('shop') ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                        <span class="mr-3 group-hover:scale-110 transition-transform">
                            <x-heroicon-o-shopping-cart class="size-5 md:size-6 rotate-y-180"/>
                        </span>
                        <span>{{ __('Boutique') }}</span>
                    </a>
                </li>
            </ul>

            <div class="pt-6 mt-6 border-t border-muted/50">
                <p class="text-[10px] font-bold text-muted uppercase  px-4 mb-4">{{ __('Communauté') }}</p>
                <ul class="space-y-2 list-none p-0 text-lg md:text-base">
                    <li>
                        <a href="{{ route('sentences') }}" wire:navigate
                            class="flex items-center p-2 md:p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('sentences') ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                            <span class="mr-3 group-hover:scale-110 transition-transform">
                                <x-lucide-message-square-text class="size-5 md:size-6" />
                            </span>
                            <span>{{ __('Exemples') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('grambuds') }}" wire:navigate
                            class="flex items-center p-2 md:p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('grambuds') ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                            <span class="mr-3 group-hover:scale-110 transition-transform">
                                <x-heroicon-o-user-group class="size-5 md:size-6" />
                            </span>
                            <span>{{ __('Grambuds') }}</span>
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="{{ route('profile.public', ['user' => auth()->user()]) }}" wire:navigate
                            class="flex items-center p-2 md:p-3 rounded-xl group transition-all duration-200 {{ (request()->routeIs('profile.public') && request()->route('user') == auth()->user()->username) ? 'bg-primary/10 text-primary shadow-sm' : 'hover:bg-muted/30' }}">
                            <span class="mr-3 group-hover:scale-110 transition-transform">
                                <x-lucide-circle-user class="size-5 md:size-6" />
                            </span>
                            <span>{{ __('Ma page publique') }}</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</aside>
