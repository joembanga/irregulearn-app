<x-app-layout>
    {{-- <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-primary to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">{{ substr(Auth::user()->username,0,1) }}</div>
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white">{{ __('Profile') }}</h2>
                <div class="text-sm text-gray-600 dark:text-gray-400">Gère les informations de ton compte et ta sécurité</div>
            </div>
        </div>
    </x-slot> --}}

    <div class="py-12">

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm mb-8 flex flex-col items-center sm:flex-row sm:justify-between">
                <div class="flex flex-col items-center sm:flex-row gap-6">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full blur opacity-25">
                        </div>
                        <img src="{{ $user->avatar_code }}"
                            class="relative w-32 h-32 rounded-full border-4 border-white dark:border-gray-700 shadow-xl">
                    </div>
        
                    <div class="text-center sm:text-left">
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white">{{ $user->username }}</h2>
                        <p class="text-indigo-600 font-bold uppercase text-xs tracking-widest">Niveau
                            {{ floor($user->xp_total / 100) }} • {{ $user->xp_total }} XP</p>
                    </div>
                </div>
        
                @if(auth()->id() === $user->id)
                <div x-data="{ open: false }">
                    <button @click="open = !open; $nextTick(() => $dispatch('scroll-to-editor'))"
                        class="mt-6 sm:mt-0 px-6 py-3 bg-gray-900 dark:bg-indigo-600 text-white rounded-2xl font-black text-sm transition hover:scale-105 active:scale-95">
                        🎭 MODIFIER MON LOOK
                    </button>
                </div>
                @endif
            </div>
        
            @if(auth()->id() === $user->id)
            <div id="avatar-section" class="mt-12 pt-12 border-t border-gray-100 dark:border-gray-800" x-data
                @scroll-to-editor.window="document.getElementById('avatar-section').scrollIntoView({ behavior: 'smooth' })">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">Personnalisation du
                        Héros</h3>
                    <p class="text-gray-500 text-sm">Crée un avatar qui te ressemble (ou pas du tout).</p>
                </div>
        
                <livewire:avatar-editor />
            </div>
            @endif
        
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
