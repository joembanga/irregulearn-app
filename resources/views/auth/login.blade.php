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
    </div>
</x-guest-layout>