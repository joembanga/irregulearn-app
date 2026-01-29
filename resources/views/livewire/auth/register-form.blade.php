<div x-cloak x-data="{ 
        firstname: '',
        lastname: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        terms: false,
        
        // Computed validation
        get nameValid() { return this.firstname.trim().length > 0 && this.lastname.trim().length > 0 },
        get usernameValid() { return /^[a-zA-Z0-9_-]{3,}$/.test(this.username) },
        get emailValid() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email) },
        get passwordValid() { return this.password.length >= 8 && /[a-zA-Z]/.test(this.password) && /[0-9]/.test(this.password) },
        get passwordsMatch() { return this.password.length > 0 && this.password === this.password_confirmation },
        get formIsValid() { return this.nameValid && this.usernameValid && this.emailValid && this.passwordValid && this.passwordsMatch && this.terms }
     }">
    <form wire:submit="register" class="space-y-4">
        <!-- Errors General -->
        @if (session('error'))
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm font-medium animate-in fade-in slide-in-from-top-2 duration-300">
            <div class="flex items-center gap-3">
                <span class="text-lg">⚠️</span>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Username -->
        <div class="space-y-1.5">
            <x-input-label for="username" :value="__('Nom d\'utilisateur')" class="text-sm font-semibold text-gray-900" />
            <div class="relative group">
                <x-text-input wire:model.blur="username" x-model="username" id="username" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400 shadow-sm transition-all pr-10" type="text" required autocomplete="username" placeholder="{{ __('mon_pseudo') }}" />

                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <!-- Spinning while Livewire checks uniqueness -->
                    <div wire:loading wire:target="username"
                        class="animate-spin h-4 w-4 border-2 border-primary border-t-transparent rounded-full">
                    </div>

                    <!-- Show status after validation -->
                    <div wire:loading.remove wire:target="username" class="flex items-center">
                        @if (!$errors->has('username') && $username !== '')
                        <x-lucide-circle-check class="size-5 text-green-500" />
                        @elseif ($errors->has('username'))
                        <x-lucide-circle-x class="size-5 text-red-500" />
                        @endif
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Firstname -->
            <div class="space-y-1.5">
                <x-input-label for="firstname" :value="__('Prénom')" class="text-sm font-semibold text-gray-900" />
                <x-text-input x-model="firstname" wire:model="firstname" id="firstname" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 shadow-sm transition-all" type="text" required autocomplete="firstname" placeholder="{{ __('Jean') }}" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-1" />
            </div>

            <!-- Lastname -->
            <div class="space-y-1.5">
                <x-input-label for="lastname" :value="__('Nom')" class="text-sm font-semibold text-gray-900" />
                <x-text-input x-model="lastname" wire:model="lastname" id="lastname" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 shadow-sm transition-all" autocomplete="lastname" placeholder="{{ __('Dupont') }}" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-1" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-900" />

            <div class="relative">
                <x-text-input wire:model.blur="email" x-model="email" id="email" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400 shadow-sm transition-all pr-10" type="email" required autocomplete="username" placeholder="{{ __('ton@email.com') }}" />

                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <div wire:loading wire:target="email" class="animate-spin h-4 w-4 border-2 border-primary border-t-transparent rounded-full"></div>

                    <div wire:loading.remove wire:target="email" class="flex items-center">
                        @if (!$errors->has('email') && $email !== '')
                        <x-lucide-circle-check class="size-5 text-green-500" />
                        @elseif ($errors->has('email'))
                        <x-lucide-circle-x class="size-5 text-red-500" />
                        @endif
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-sm font-semibold text-gray-900" />
            <div class="relative">
                <x-text-input x-model="password" wire:model="password" id="password" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400 shadow-sm transition-all pr-10"
                    x-bind:class="password.length > 0 ? (passwordValid ? 'border-green-500 ring-green-500' : 'border-red-500 ring-red-500') : 'border-gray-300'"
                    x-bind:type="show ? 'text' : 'password'" required autocomplete="new-password"
                    placeholder="{{ __('Min. 8 caractères') }}" />
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary transition-colors">
                    <x-lucide-eye class="size-5" x-show="!show" />
                    <x-lucide-eye-closed class="size-5" x-show="show" />
                </button>
            </div>
            <div x-show="password.length > 0 && !passwordValid" class="mt-1.5 space-y-1 animate-in fade-in slide-in-from-left-2 transition-all">
                <p class="text-[10px] font-bold uppercase tracking-wider"
                    :class="password.length >= 8 ? 'text-green-600' : 'text-red-600'">
                    • {{ __('8 caractères minimum') }}
                </p>
                <p class="text-[10px] font-bold uppercase tracking-wider"
                    :class="/[a-zA-Z]/.test(password) && /[0-9]/.test(password) ? 'text-green-600' : 'text-red-600'">
                    • {{ __('Une lettre et un chiffre') }}
                </p>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5" x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-sm font-semibold text-gray-900" />
            <div class="relative">
                <x-text-input x-model="password_confirmation" wire:model="password_confirmation"
                    id="password_confirmation" class="block w-full px-4 py-2.5 rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400 shadow-sm transition-all pr-10"
                    x-bind:class="password_confirmation.length > 0 ? (passwordsMatch ? 'border-green-500 ring-green-500' : 'border-red-500 ring-red-500') : 'border-gray-300'"
                    x-bind:type="show ? 'text' : 'password'" required autocomplete="new-password"
                    placeholder="••••••••" />
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary transition-colors">
                    <x-lucide-eye class="size-5" x-show="!show" />
                    <x-lucide-eye-closed class="size-5" x-show="show" />
                </button>
            </div>
            <p x-show="password_confirmation.length > 0 && !passwordsMatch"
                class="mt-1 text-[11px] text-red-600 font-medium">{{ __('Les mots de passe ne correspondent pas') }}</p>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-start mt-2">
            <div class="flex items-center h-5">
                <input id="terms" type="checkbox" wire:model="terms" x-model="terms" required
                    class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/20 transition-all cursor-pointer">
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="font-medium text-gray-600 cursor-pointer">
                    {{ __('J\'accepte les') }}
                    <a href="{{ route('terms') }}" class="font-bold text-primary hover:underline">{{ __('Termes') }}</a>,
                    <a href="{{ route('privacy') }}" class="font-bold text-primary hover:underline">{{ __('Confidentialité') }}</a>
                    {{ __('et') }}
                    <a href="#" class="font-bold text-primary hover:underline">{{ __('Cookies') }}</a>.
                </label>
            </div>
        </div>
        <x-input-error :messages="$errors->get('terms')" class="mt-1" />

        <x-primary-button type="submit" x-bind:disabled="!formIsValid" wire:loading.attr="disabled" class="w-full py-2.5 mt-2 flex flex-row items-center justify-center gap-2 transition-all duration-300 bg-primary text-white rounded-lg font-bold shadow-sm" 
            x-bind:class="!formIsValid ? 'opacity-50 cursor-not-allowed grayscale' : 'hover:bg-primary/90 active:scale-[0.98]'">

            <!-- Standard State -->
            <span wire:loading.remove wire:target="register">
                <span x-show="formIsValid">{{ __('Créer mon compte') }}</span>
                <span x-show="!formIsValid">{{ __('Formulaire incomplet') }}</span>
            </span>

            <!-- Loading State -->
            <span wire:loading wire:target="register" class="flex flex-row items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('Création en cours...') }}</span>
            </span>
        </x-primary-button>
    </form>
</div>