<div class="space-y-8">
    <form wire:submit="register" class="space-y-5">
        <!-- Errors General -->
        @if (session('error'))
            <div class="p-4 bg-danger-10 border-l-4 border-danger text-danger rounded-r-2xl text-sm font-medium animate-in fade-in slide-in-from-top-2 duration-300">
                <div class="flex items-center gap-3">
                    <span class="text-lg">⚠️</span>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Username -->
        <div class="space-y-2">
            <x-input-label for="username" :value="__('Nom d\'utilisateur')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
            <div class="relative group">
                <x-text-input wire:model.live.debounce.300ms="username" id="username" class="block w-full pr-10 {{ $errors->has('username') ? 'border-danger focus:ring-danger/50' : ($username && !$errors->has('username') ? 'border-success focus:ring-success/50' : '') }}" type="text" required autocomplete="username" placeholder="mon_pseudo" />
                
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    @if($errors->has('username'))
                        <span class="text-danger">❌</span>
                    @elseif($username && !$errors->has('username'))
                        <span class="text-success">✅</span>
                    @endif
                </div>
            </div>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
            @if($username && !$errors->has('username'))
                <p class="mt-1 text-xs text-success font-medium ml-1">pseudo disponible !</p>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Firstname -->
            <div class="space-y-2">
                <x-input-label for="firstname" :value="__('Prénom')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
                <x-text-input wire:model.live.debounce.300ms="firstname" id="firstname" class="block w-full {{ $errors->has('firstname') ? 'border-danger' : '' }}" type="text" required autocomplete="firstname" placeholder="Jean" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>

            <!-- Lastname -->
            <div class="space-y-2">
                <x-input-label for="lastname" :value="__('Nom')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
                <x-text-input wire:model.live.debounce.300ms="lastname" id="lastname" class="block w-full {{ $errors->has('lastname') ? 'border-danger' : '' }}" type="text" required autocomplete="lastname" placeholder="Dupont" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
            <div class="relative">
                <x-text-input wire:model.live.debounce.300ms="email" id="email" class="block w-full pr-10 {{ $errors->has('email') ? 'border-danger' : ($email && !$errors->has('email') ? 'border-success' : '') }}" type="email" required autocomplete="username" placeholder="ton@email.com" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    @if($errors->has('email'))
                        <span class="text-danger text-xs">Email invalide</span>
                    @elseif($email && !$errors->has('email'))
                        <span class="text-success">✅</span>
                    @endif
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Mot de passe')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
            <div class="relative">
                <x-text-input wire:model.live.debounce.300ms="password" id="password" class="block w-full pr-10 {{ $errors->has('password') ? 'border-danger' : '' }}" ::type="show ? 'text' : 'password'" required autocomplete="new-password" placeholder="Mot de passe" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-6 flex items-center text-muted hover:text-primary transition-colors">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="ml-1 text-muted uppercase text-[10px] tracking-widest" />
            <div class="relative">
                <x-text-input wire:model.live.debounce.300ms="password_confirmation" id="password_confirmation" class="block w-full pr-10 {{ $errors->has('password_confirmation') ? 'border-danger' : ($password && $password === $password_confirmation ? 'border-success' : '') }}" ::type="show ? 'text' : 'password'" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 mr-6 flex items-center text-muted hover:text-primary transition-colors">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full py-4 mt-4 flex items-center justify-center gap-2">
            <span wire:loading.remove wire:target="register">{{ __('Créer mon compte') }}</span>
            <span wire:loading wire:target="register" class="flex flex-row items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Chargement...
            </span>
        </x-primary-button>
    </form>
</div>
