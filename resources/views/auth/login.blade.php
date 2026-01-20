<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
    <div class="mb-6 p-4 bg-danger-10 border-l-4 border-danger text-danger rounded-r-2xl text-sm font-medium animate-in fade-in slide-in-from-top-2 duration-300">
        <div class="flex items-center gap-3">
            <span class="text-lg">⚠️</span>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-body tracking-tight">Bon retour !</h2>
            <p class="mt-2 text-muted font-medium">Continue ton apprentissage là où tu t'es arrêté.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
                <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" placeholder="ton@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex items-center justify-between ml-1">
                    <x-input-label for="password" :value="__('Mot de passe')" class="text-muted uppercase text-[10px] tracking-widest" />
                    @if (Route::has('password.request'))
                    <a class="text-[11px] font-bold text-primary hover:text-primary/80 transition-colors"
                        href="{{ route('password.request') }}">
                        {{ __('Oublié ?') }}
                    </a>
                    @endif
                </div>
                <x-text-input id="password" class="block w-full" type="password" name="password" required
                    autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <input id="remember_me" type="checkbox"
                        class="rounded-md border-muted text-primary shadow-sm focus:ring-primary/20 transition-all cursor-pointer" name="remember">
                    <span class="ml-2 text-sm text-muted group-hover:text-body transition-colors">{{ __('Rester connecté') }}</span>
                </label>
            </div>

            <x-primary-button class="w-full py-4 mt-2">
                {{ __('Se connecter') }}
            </x-primary-button>
        </form>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-muted/50"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="px-4 bg-surface text-muted font-bold uppercase tracking-widest">ou</span>
            </div>
        </div>

        <a href="{{ route('auth.google') }}"
            class="flex items-center justify-center gap-3 w-full px-6 py-4 bg-surface border border-muted rounded-2xl font-bold text-body hover:bg-muted/5 hover:border-muted-foreground transition-all duration-200 hover:scale-[1.01] active:scale-[0.99] shadow-sm">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4"
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853"
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05"
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                <path fill="#EA4335"
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.63l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
            </svg>
            <span>Continuer avec Google</span>
        </a>

        <p class="text-center text-sm text-muted">
            Pas encore de compte ? 
            <a href="{{ route('register') }}" wire.navigate class="font-bold text-primary hover:text-primary/80 transition-colors">
                Inscris-toi
            </a>
        </p>
    </div>
</x-guest-layout>