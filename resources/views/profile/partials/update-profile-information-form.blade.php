<section>
    <header>
        <h2 class="text-lg font-medium text-body">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 transition">
        @csrf
        @method('patch')
                <div class="space-y-4">
                    <div>
                        <x-input-label for="firstname" :value="__('Prénom')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
                    <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full"
                        :value="old('firstname', $user->firstname)" required autocomplete="firstname" />
                    <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
                </div>

                    <div class="mt-4">
                        <x-input-label for="lastname" :value="__('Nom')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
                    <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full"
                        :value="old('lastname', $user->lastname)" required autocomplete="lastname" />
                    <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
                </div>

                    <div class="mt-4">
                        <x-input-label for="username" :value="__('Username')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                        :value="old('username', $user->username)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-body">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-muted hover:text-body rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div>
                <div class="p-4 sm:p-8 bg-surface shadow sm:rounded-2xl border border-muted">
                    <div class="max-w-xl">
                        <section>
                            <header class="mb-4">
                                <h3 class="text-sm font-black text-body uppercase tracking-widest">Objectif Quotidien</h3>
                                <p class="mt-1 text-sm text-muted">Combien de nouveaux verbes
                                    veux-tu apprendre chaque jour ?</p>
                            </header>
                            <div>
                                <select name="daily_target"
                                    class="border-muted focus:border-primary focus:ring-primary rounded-xl shadow-sm w-full dark:bg-gray-900/50 dark:text-white">
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