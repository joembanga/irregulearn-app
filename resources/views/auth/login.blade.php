<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="grid grid-cols-1 gap-8 items-center">
        <div class="text-center lg:text-left px-6">
            <div
                class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-medium mb-4">
                🚀 Bienvenue
            </div>
            <h2 class="text-3xl font-extrabold text-body mb-2">Connecte-toi</h2>
            <p class="text-muted">Reprends ta progression, protège ta streak et continue à gagner
                des XP.</p>
        </div>

        <form method="POST" action="{{ route('login') }}"
            class="p-6 bg-surface rounded-2xl shadow-sm border border-muted">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-muted text-primary shadow-sm focus:ring-accent" name="remember">
                    <span class="ml-2 text-sm text-muted">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-primary hover:text-primary/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
                <x-primary-button class="ml-3">
                    {{ __('Se connecter') }}
                </x-primary-button>
            </div>
        </form>

        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-muted"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-background text-muted italic">ou</span>
            </div>
        </div>

        <a href="{{ route('auth.google') }}"
            class="flex items-center justify-center gap-3 w-full px-6 py-4 bg-surface rounded-2xl border border-muted font-bold text-body hover:bg-muted/10 transition-all hover:scale-[1.02] active:scale-[0.98] shadow-sm">
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
    </div>
</x-guest-layout>