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

<div class="space-y-6">
    <div class="text-left">
        <h2 class="text-2xl font-bold text-gray-900 ">{{ __('Bon retour !') }}</h2>
    </div>

    <a href="{{ route('auth.google') }}"
        class="flex items-center justify-center gap-3 w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all duration-200">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.63l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
        </svg>
        <span>{{ __('Continuer avec Google') }}</span>
    </a>

    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-3 bg-white text-gray-500 font-medium uppercase tracking-wider">{{ __('ou') }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-900" />
            <x-text-input id="email" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400 shadow-sm transition-all" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-sm font-semibold text-gray-900" />
                @if (Route::has('password.request'))
                <a class="text-sm font-bold text-primary hover:underline transition-all"
                    href="{{ route('password.request') }}">
                    {{ __('Oublié ?') }}
                </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400 shadow-sm transition-all" type="password" name="password" required
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all cursor-pointer" name="remember">
                <span class="ml-2 text-sm font-medium text-gray-600">{{ __('Rester connecté') }}</span>
            </label>
        </div>

        <x-primary-button class="w-full py-2.5 text-sm font-bold bg-primary hover:bg-primary/90 rounded-lg shadow-sm transition-all active:scale-[0.98]">
            {{ __('Se connecter') }}
        </x-primary-button>
    </form>

    <p class="text-sm font-medium text-gray-500">
        {{ __('Pas encore de compte ? ') }}
        <a href="{{ route('register') }}" wire:navigate class="font-bold text-primary hover:underline transition-all">
            {{ __('S\'inscrire') }}
        </a>
    </p>
</div>
</x-guest-layout>