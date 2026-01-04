<x-app-layout>

    <div class="py-12">

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <div
                class="card-surface rounded-3xl p-8 shadow-sm mb-8 flex flex-col items-center sm:flex-row sm:justify-between border border-muted">
                <div class="flex flex-col items-center sm:flex-row gap-6">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full blur opacity-25">
                        </div>

                        @if(!empty($user->avatar_code))
                        @php
                        $options = [];
                        parse_str($user->avatar_code, $options);
                        @endphp
                        <img src="{{ 'https://avataaars.io/?' . http_build_query($options) }}" alt="Avatar"
                            class="relative w-32 h-32 rounded-full border-4 border-white dark:border-gray-700 shadow-xl object-cover">
                        @else
                        <div
                            class="relative w-32 h-32 rounded-full bg-primary/20 flex items-center justify-center text-primary font-black text-5xl border-4 border-white dark:border-gray-700 shadow-xl">
                            {{ substr(\Illuminate\Support\Str::upper($user->username), 0, 1) }}
                        </div>
                        @endif
                    </div>

                    <div class="text-center sm:text-left">
                        <h2 class="text-3xl font-black text-body">{{ $user->firstname }}
                            {{ $user->lastname }}</h2>
                        <p class="text-primary font-bold text-xs tracking-widest">{{ $user->username }} •
                            {{ $user->xp_total }} XP</p>
                    </div>
                </div>

                @if(auth()->id() === $user->id)
                <div x-data="{ open: false }">
                    <button @click="open = !open; $nextTick(() => $dispatch('scroll-to-editor'))"
                        class="mt-6 sm:mt-0 px-6 py-3 btn-invert rounded-2xl font-black text-sm transition hover:scale-105 active:scale-95">
                        🎭 MODIFIER MON LOOK
                    </button>
                </div>
                @endif
            </div>

            @if(auth()->id() === $user->id)
            <div id="avatar-section" class="mt-12 pt-12 border-t border-muted" x-data
                @scroll-to-editor.window="document.getElementById('avatar-section').scrollIntoView({ behavior: 'smooth' })">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-body uppercase tracking-tighter">
                        Personnalisation du
                        Héros</h3>
                    <p class="text-muted text-sm">Crée un avatar qui te ressemble (ou pas du tout).</p>
                </div>
                <livewire:avatar-editor />
            </div>
            @endif

        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div
                class="p-4 sm:p-8 bg-surface shadow sm:rounded-lg transition">
                <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div
                class="p-4 sm:p-8 bg-surface shadow sm:rounded-lg transition">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div
                class="p-4 sm:p-8 bg-surface shadow sm:rounded-lg transition">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>