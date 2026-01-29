<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Merci de t\'etre enregistré ! Avant de commenecer, peux tu vérifier tes emails et cliquer sur le lien que nous venons juste de t\'envoyer ? Si tu n\'en a pas reçu, nous le renverons volontiers.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Un nouveau lien a été envoyé à l\'addresse email que tu avais renseigné pendant ton enregistrement.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Envoyer un autre email de vérification') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-muted hover:text-gray-900 dark:hover:text-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>
