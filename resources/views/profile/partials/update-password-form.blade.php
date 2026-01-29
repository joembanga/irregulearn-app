<section>
    <header>
        <h2 class="text-lg font-medium text-body">
            {{ __('Modifier le Mot de Passe') }}
        </h2>

        <p class="mt-1 text-sm text-muted">
            {{ __('Choisi un mot de passe fort et simple à retenir.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-success">{{ __('Mot de passe modifié !') }}</p>
            @endif
        </div>
    </form>
</section>