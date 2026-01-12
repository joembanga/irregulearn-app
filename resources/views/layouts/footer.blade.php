<footer class="bg-surface border-t border-muted py-6 lg:py-12 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1 md:col-span-2">
                <a href="/" wire.navigate class="flex items-center gap-2 mb-6">
                    <x-application-logo />
                </a>
                <p class="text-muted text-sm max-w-sm leading-relaxed">
                    {{ __("Maîtrisez les verbes irréguliers anglais avec une approche moderne et récompensée. Déjà des milliers d'élèves progressent chaque jour.") }}
                </p>
            </div>

            <div>
                <h4 class="font-bold text-body mb-6 uppercase text-[10px] tracking-[0.2em]">{{ __('Application') }}</h4>
                <nav class="flex flex-col gap-3 text-sm">
                    <a href="{{ route('learn.index') }}" wire:navigate
                        class="text-muted hover:text-primary transition-colors font-medium">{{ __('Apprendre') }}</a>
                    <a href="{{ route('leaderboard') }}" wire:navigate
                        class="text-muted hover:text-primary transition-colors font-medium">{{ __('Classement') }}</a>
                    <a href="{{ route('shop') }}" wire:navigate
                        class="text-muted hover:text-primary transition-colors font-medium">{{ __('Boutique') }}</a>
                    <a href="{{ route('search') }}" wire:navigate
                        class="text-muted hover:text-primary transition-colors font-medium">{{ __('Recherche') }}</a>
                </nav>
            </div>

            <div>
                <h4 class="font-bold text-body mb-6 uppercase text-[10px] tracking-[0.2em]">{{ __('Légal') }}</h4>
                <nav>
                    <ul class="flex flex-col gap-3 text-sm list-none">
                        <li>
                            <a href="{{ route('about') }}" wire:navigate
                                class="text-muted hover:text-primary transition-colors font-medium">{{ __('À propos') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('privacy') }}" wire:navigate
                                class="text-muted hover:text-primary transition-colors font-medium">{{ __('Confidentialité') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" wire:navigate
                                class="text-muted hover:text-primary transition-colors font-medium">{{ __('Contact') }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="mt-16 pt-8 border-t border-muted/50 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs text-muted font-medium">
                &copy; {{ date('Y') }} IrreguLearn. {{ __("Fait avec passion pour l'éducation.") }}
            </p>
            
            <div class="flex items-center gap-4 bg-app/50 rounded-full px-4 py-2 border border-muted/50">
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'fr'])) }}" wire:navigate
                   class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider {{ app()->getLocale() == 'fr' ? 'text-primary' : 'text-muted hover:text-body' }} transition-colors">
                    <span>🇫🇷</span> FR
                </a>
                <div class="w-px h-3 bg-muted"></div>
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}" wire:navigate
                   class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider {{ app()->getLocale() == 'en' ? 'text-primary' : 'text-muted hover:text-body' }} transition-colors">
                    <span>🇬🇧</span> EN
                </a>
            </div>

            <div class="text-[10px] text-muted uppercase tracking-widest font-bold">
                Kinshasa • Paris • Londres
            </div>
        </div>
    </div>
</footer>