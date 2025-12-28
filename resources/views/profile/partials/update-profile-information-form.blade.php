<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-700">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="grid grid-cols-1 gap-8">
            <div>
                <div>
                    <x-input-label for="firstname" :value="__('Firstname')" />
                    <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full"
                        :value="old('firstname', $user->firstname)" required autocomplete="firstname" />
                    <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
                </div>

                <div>
                    <x-input-label for="lastname" :value="__('Lastname')" />
                    <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full"
                        :value="old('lastname', $user->lastname)" required autocomplete="lastname" />
                    <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div>
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Objectif Quotidien</h2>
                                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Combien de nouveaux verbes
                                    veux-tu apprendre chaque jour ?</p>
                            </header>
                            <div>
                                <select name="daily_target"
                                    class="border-gray-300 focus:border-primary focus:ring-primary rounded-xl shadow-sm w-full">
                                    <option value="3" {{ auth()->user()->daily_target === 3 ? 'selected' : '' }}>3
                                        verbes
                                    </option>
                                    <option value="5" {{ auth()->user()->daily_target === 5 ? 'selected' : '' }}>5
                                        verbes
                                    </option>
                                    <option value="10" {{ auth()->user()->daily_target === 10 ? 'selected' : '' }}>10
                                        verbes
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('daily_target')" />
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-700">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>