<x-guest-layout>
    <div class="w-auto grid grid-cols-1 gap-8 items-center">
        <div class="px-6 text-center lg:text-left">
            <div
                class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-medium mb-4">
                🎓 Commence maintenant</div>
            <h2 class="text-3xl font-extrabold text-body mb-2">Créer un compte</h2>
            <p class="text-muted">Rejoins la communauté, débloque des catégories et améliore ta grammaire anglaise
                anglais jour après jour.</p>
        </div>

        <form method="POST" action="{{ route('register') }}"
            class="p-6 bg-surface rounded-2xl shadow-sm border border-muted">
            @csrf

            <div class="mb-6 text-center">
                <h3 class="text-lg font-semibold text-body">Inscription rapide</h3>
                <p class="mt-1 text-sm text-muted">Quelques informations pour personnaliser ton
                    expérience.</p>
            </div>

            <!-- Username -->
            <livewire:register-username-input />

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <x-input-label for="firstname" :value="__('Firstname')" />
                    <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname"
                        :value="old('firstname')" required autofocus autocomplete="firstname" />
                    <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="lastname" :value="__('Lastname')" />
                    <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname"
                        :value="old('lastname')" required autocomplete="lastname" />
                    <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-muted hover:text-body rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Créer mon compte') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>